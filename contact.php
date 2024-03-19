<?php
session_start();


// Check if the user is already logged in
if (isset($_SESSION['Username'])) {
    $role = $_SESSION['RoleID'];
    switch ($role) {
        case '1':
            header("Location: Schedule/system_admin.php");
            break;
        case '2':
            header("Location: Schedule/school_director.php");
            break;
        case '3':
            header("Location: Schedule/assistant.php");
            break;
        case '4':
            header("Location: Schedule/instructor.php");
            break;
        default:
            header("Location: Schedule/redirect.php");
            break;
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
	<title>Contact</title>

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
	</head>
	<body>	
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
		<section class="banner-area relative about-banner" id="home">	
			<div class="overlay overlay-bg"></div>
			<div class="container">				
				<div class="row d-flex align-items-center justify-content-center">
					<div class="about-content col-lg-12">
						<h1 class="text-white">
							Contact Us				
						</h1>	
				</div>
			</div>
		</section>
		<!-- End banner Area -->				  

		<!-- Start contact-page Area -->
		<section class="contact-page-area section-gap">
			<div class="container">
				<div class="row">
				<div class="map-wrap" style="width: 100%; height: 445px;">
<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3856.386685203098!2d120.24379690877323!3d14.85964068559817!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3396777faaa0f1f3%3A0xae93d9446cc51900!2sSmart%20Achievers%20Academy-%20Subic%2C%20Inc.!5e0!3m2!1sen!2sph!4v1694531023025!5m2!1sen!2sph"
	width="100%" height="445" frameborder="0" style="border:0" allowfullscreen></iframe>
</div>

					<div class="col-lg-4 d-flex flex-column address-wrap">
						<div class="single-contact-address d-flex flex-row">
							<div class="icon">
								<span class="lnr lnr-home"></span>
							</div>
							<div class="contact-details">
								<h5>Address</h5>
								<p>
									Blk. 4 Lots 3 & 4 St. James Subd., Calapacuan, Subic, Zambales
								</p>
							</div>
						</div>
						<div class="single-contact-address d-flex flex-row">
							<div class="icon">
								<span class="lnr lnr-phone-handset"></span>
							</div>
							<div class="contact-details">
								<h5>Landline Number</h5>
								<p>(047) 232-8224</p>
							</div>
						</div>
						<div class="single-contact-address d-flex flex-row">
							<div class="icon">
								<span class="lnr lnr-smartphone"></span> <!-- Icon for mobile -->
							</div>
							<div class="contact-details">
								<h5>Mobile Number</h5>
								<p>0998 550 1994, 0930 366 6559, 0917 834 8413</p>
							</div>
							</div>
						<div class="single-contact-address d-flex flex-row">
							<div class="icon">
								<span class="lnr lnr-envelope"></span>
							</div>
							<div class="contact-details">
								<h5>Email</h5>
								<p>Email: smartkidsmontessori@yahoo.com</p>
							</div>
						</div>														
					</div>
					<div class="col-lg-8">
						<form class="form-area contact-form text-right" id="myForm" action="mail.php" method="post">
							<div class="row">	
								<div class="col-lg-6 form-group">
									<input name="name" placeholder="Enter your name" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter your name'" class="common-input mb-20 form-control" required="" type="text">
								
									<input name="email" placeholder="Enter email address" pattern="[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Za-z]{1,63}$" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter email address'" class="common-input mb-20 form-control" required="" type="email">

									<input name="subject" placeholder="Enter subject" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter subject'" class="common-input mb-20 form-control" required="" type="text">
								</div>
								<div class="col-lg-6 form-group">
									<textarea class="common-textarea form-control" name="message" placeholder="Enter Messege" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Enter Messege'" required=""></textarea>				
								</div>
								<div class="col-lg-12">
									<div class="alert-msg" style="text-align: left;"></div>
									<button class="genric-btn primary" style="float: right;">Send Message</button>											
								</div>
							</div>
						</form>	
					</div>
				</div>
			</div>	
		</section>
		<!-- End contact-page Area -->

		<!-- start footer Area -->		
		<footer class="footer-area section-gap">
<div class="container">
	<div class="row">
		<div class="col">
			<div class="single-footer-widget">
				<h4><i class="fas fa-map-marker-alt"></i> Address:</h4>
				<p class="text-white"><i class="fas fa-map-marker-alt"></i> Blk. 4 Lots 3 & 4 St. James Subd., Calapacuan, Subic, Zambales</p>
			</div>
		</div>
		<div class="col">
			<div class="single-footer-widget">
				<h4><i class="fas fa-phone"></i> Contact:</h4>
				<p class="text-white"><i class="fas fa-phone-alt"></i> Landline Number: (047) 232-8224</p>
				<p class="text-white"><i class="fas fa-mobile-alt"></i> Mobile Number: 0998 550 1994, 0930 366 6559, 0917 834 8413</p>
			</div>
		</div>
		<div class="col">
			<div class="single-footer-widget">
				<h4 class="text-white">Social Media:</h4>
				<a href="https://www.facebook.com/SAASIans" target="_blank">
	<i class="fab fa-facebook"></i></a> 
	<lu class="text-white">Facebook: Smart Achievers Academy - Subic, Inc.</i>
				<p class="text-white"><i class="fas fa-envelope"></i> Email: smartkidsmontessori@yahoo.com</p>
			</div>
		</div>
	</div>
</footer>

<footer class="custom-footer">
<div class="row align-items-center justify-content-center">
	<div class="col-lg-12">
		
		<div class="copyright-container text-center">
			<p class="text-black">
				Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | COMTEQ Computer & Business College Inc.
			</p>
		</div>
	</div>
</div>
</footer>
		<!-- End footer Area -->	


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