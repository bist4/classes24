<?php
session_start();


// Check if the user is already logged in
if (isset($_SESSION['Username'])) {
    
	$role = [
        $row['is_Instructor'],
        $row['is_SchoolDirector'],
        $row['is_SchoolDirectorAssistant']
    ];

    $positionRole = '';

    $admin = $row['UserTypeID'];

    $role = [
        $row['is_Instructor'],
        $row['is_SchoolDirector'],
        $row['is_SchoolDirectorAssistant']
    ];
    
    $admin = $row['UserTypeID'];
    
    if ($role[0] == 1) {
		header("Location: Schedule/instructor.php");
        exit();
    } elseif ($role[1] == 1) {
        header("Location: Schedule/school_director.php");
        exit();
    } elseif ($role[2] == 1) {
        header("Location: Schedule/assistant.php");
        exit();
    } elseif ($admin == 2) {
		header("Location: Schedule/system_admin.php");
        exit();
    } else {
        // Handle any other cases, or redirect to a default page
		header("Location: Schedule/redirect.php");
        exit();
    }
    exit();
}
?>

<!DOCTYPE html>
	<html lang="zxx" class="no-js">
	<head>
		<!-- Mobile Specific Meta -->
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<!-- Favicon-->
		<link rel="shortcut icon" href="img/fav.png">
		<!-- Author Meta -->
		<meta name="author" content="colorlib">
		<!-- Meta Description -->
		<meta name="description" content="">
		<!-- Meta Keyword -->
		<meta name="keywords" content="">
		<!-- meta character set -->
		<meta charset="UTF-8">
		<!-- Site Title -->
		<link rel="icon" href="/class-sceduling/img/logo.ico" type="image/x-icon">
		<title>Home</title>

		<link href="https://fonts.googleapis.com/css?family=Poppins:100,200,400,300,500,600,700" rel="stylesheet"> 
			<!--
			CSS
			============================================= -->
			<link rel="stylesheet" href="css/linearicons.css">
			<link rel="stylesheet" href="css/font-awesome.min.css">
			<link rel="stylesheet" href="css/bootstrap.css">
			<link rel="stylesheet" href="css/magnific-popup.css">
			<link rel="stylesheet" href="css/nice-select.css">							
			<link rel="stylesheet" href="css/animate.min.css">
			<link rel="stylesheet" href="css/owl.carousel.css">			
			<link rel="stylesheet" href="css/jquery-ui.css">			
			<link rel="stylesheet" href="css/main.css">
			<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.0/css/all.min.css">
	
			<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    	<link rel="stylesheet" href="css/style.css">
		</head>
	<body>	
 
	<header id="header" id="home">
        <div class="container main-menu">
            <div class="row align-items-center justify-content-between d-flex">
                <div id="logo">
                    <img src="img/logo.png" alt="" title="" />
                    <a href="index.php" class="logo-link">
                        <div class="logo-line">Smart Achievers</div>
                        <div class="logo-line">Academy Subic Inc.</div>
                    </a>
                </div>

           
				<nav id="nav-menu-container">
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : ''; ?>" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'about.php' ? 'active' : ''; ?>" href="about.php">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'events.php' ? 'active' : ''; ?>" href="events.php">Events</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'contact.php' ? 'active' : ''; ?>" href="contact.php">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo basename($_SERVER['PHP_SELF']) == 'Schedule/redirect.php' ? 'active' : ''; ?>" href="Schedule/redirect.php">Sign In</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</header>	

			<!-- start banner Area -->
		<section class="banner-area relative" id="home">
			<div class="overlay overlay-bg"></div>
			<div class="container">
				<div class="row fullscreen d-flex align-items-center justify-content-between">
					<div class="banner-content col-lg-9 col-md-12">
						<div class="embed-responsive embed-responsive-16by9">
		</div>
						<h1 class="text-uppercase">
							Welcome to Smart Achievers Academy - Subic, Inc.
						</h1>
						<p class="pt-10 pb-10">
							Smart Achievers Academy-Subic Inc. is a nonsectarian, private institution that offers education.
						</p>
					</div>
				</div>
			</div>
		</section>
	


			<script src="js/vendor/jquery-2.2.4.min.js"></script>
			<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
			<script src="js/vendor/bootstrap.min.js"></script>			
			<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBhOdIF3Y9382fqJYt5I_sswSrEw5eihAA"></script>
  			<script src="js/easing.min.js"></script>			
			<script src="js/hoverIntent.js"></script>
			<script src="js/superfish.min.js"></script>	
			<script src="js/jquery.ajaxchimp.min.js"></script>
			<script src="js/jquery.magnific-popup.min.js"></script>	
    		<script src="js/jquery.tabs.min.js"></script>						
			<script src="js/jquery.nice-select.min.js"></script>	
			<script src="js/owl.carousel.min.js"></script>									
			<script src="js/mail-script.js"></script>	
			<script src="js/main.js"></script>	
		</body>
	</html>