<?php
require('../../config/db_connection.php');

if (isset($_POST['department'])) {
    $department = $_POST['department'];

    // Fetch subjects for the selected department
    $query = "SELECT * FROM classschedule 
              WHERE department = '$department' 
              AND Active = 1";

    $result = $conn->query($query);

    $instructors = [];

    while ($row = $result->fetch_assoc()) {
        $key = $row['Instructor'] . '_' . $row['Time_Start'] . '_' . $row['Time_End'];

        if (!isset($instructors[$key])) {
            $instructors[$key] = [
                'Days' => [],
                'Time_Start' => $row['Time_Start'],
                'Time_End' => $row['Time_End'],
                'Subject' => $row['Subject'],
                'Instructor' => $row['Instructor'],
                'YearLevel' => $row['YearLevel'],
                'Room' => $row['Room'],
            ];
        }

        $instructors[$key]['Days'][] = $row['Day'];
    }

    // Define the order of days
    $orderOfDays = ['M' => 1, 'T' => 2, 'W' => 3, 'TH' => 4, 'F' => 5];

    // Sort instructors based on the order of days
    uasort($instructors, function ($a, $b) use ($orderOfDays) {
        $dayA = reset($a['Days']);
        $dayB = reset($b['Days']);
        return $orderOfDays[$dayA] - $orderOfDays[$dayB];
    });

    foreach ($instructors as $instructor) {
        $days = $instructor['Days'];
        $mergedDays = implode(', ', $days);
    ?>
        <tr>
            <td>
                <?php echo $instructor['Subject']; ?>
            </td>
            <td>
                <?php echo $mergedDays; ?>
            </td>
            <td>
                <?php
                $timeStart = date("h:i A", strtotime($instructor['Time_Start']));
                $timeEnd = date("h:i A", strtotime($instructor['Time_End']));
                echo $timeStart . ' - ' . $timeEnd;
                ?>
            </td>
            <td>
                <?php echo $instructor['YearLevel']; ?>
            </td>
            <td>
                <?php echo $instructor['Room']; ?>
            </td>
        </tr>
    <?php
    }

    // Close the result set
    $result->close();
} else {
    echo '<option disabled selected>Select Department</option>';
}
?>
