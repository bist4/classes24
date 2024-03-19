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
		<title>Events</title>

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
								School Events				
							</h1>	
							 
						</div>	
					</div>
				</div>
			</section>
			<div class="container">
    <section class="video mt-5">
        <div class="row">
            <div class="col-md-6">
				<h2>Yearly Events</h2>
                <p>
				Watch the Video to learn about the Smart Achievers Academy Subic Inc.
				Smart Achievers Academy-Subic Inc. is a nonsectarian, private institution that offers educational
				SAASI emphasizes the significance of hands-on experiences in the learning process. Driven by the belief that true education is not solely derived from listening to words but is instead a holistic encounter with one's environment, the academy fosters an environment where students actively engage with their surroundings.
				The curriculum at SAASI is thoughtfully designed to facilitate each child's natural development, encouraging self-discovery and independent thinking. The Montessori method, renowned for its child-centered approach, is implemented through a carefully crafted curriculum that integrates academic, social, and practical skills seamlessly.
                </p>
            </div>
            <div class="col-md-6">
                <video width="100%" height="auto" controls>
                    <source src="images/courses-video.mp4" type="video/mp4">
                    <!-- Your browser does not support the video tag. -->
                </video>
            </div>
        </div>
    </section>
</div>

			<!-- End banner Area -->	
			<section class="popular-course-area section-gap">
				<div class="container">
					<div class="row d-flex justify-content-center">
						<div class="menu-content pb-70 col-lg-8">
						</div>
					</div>						
					<div class="row">
						<div class="active-popular-carusel">
							<div class="single-popular-carusel">
								<div class="thumb-wrap relative">
									<div class="thumb relative">
										<div class="overlay overlay-bg"></div>	
										<img class="img-fluid" src="images/Picture14.1.png" alt="">
									</div>							
								</div>
								<div class="details">
									<a href="#">
										<h4>
										Christian Activities
										</h4>
									</a>
									<p>
									Celebrating the Christian foundation for the following holidays: Thanksgiving, Christmas, & Easter for spiritual. 										
									</p>
								</div>
							</div>	
							<div class="single-popular-carusel">
								<div class="thumb-wrap relative">
									<div class="thumb relative">
										<div class="overlay overlay-bg"></div>	
										<img class="img-fluid" src="images/Pictures7.png" alt="">
									</div>									
								</div>
								<div class="details">
									<a href="#">
										<h4>
										July: Nutrition Month
										</h4>
									</a>
									<p>
									~Celebrated for the purpose of helping the kid's focus, to encourage everyone to eat healthy building resilience against malnutrition & try new food and not be a picky eater
                                     also it helps on knowing a variety of foods to eat.
									</p>
								</div>
							</div>	
							<div class="single-popular-carusel">
								<div class="thumb-wrap relative">
									<div class="thumb relative">
										<div class="overlay overlay-bg"></div>	
										<img class="img-fluid" src="images/Pictures8.png"alt="">
									</div>								
								</div>
								<div class="details">
									<a href="#">
										<h4>
										August: Buwan ng Wika
										</h4>
									</a>
									<p>
									This is celebrated to give importance and value to our National language and to remind us our rich culture.
									</p>
								</div>
							</div>	
							<div class="single-popular-carusel">
								<div class="thumb-wrap relative">
									<div class="thumb relative">
										<div class="overlay overlay-bg"></div>	
										<img class="img-fluid" src="images/Pictures9.png" alt="">
									</div>									
								</div>
								<div class="details">
									<a href="#">
										<h4>
										September: Career Expo
										</h4>
									</a>
									<p>
									Holding career exposure that aims to aid the students in choosing an career path in the future
									and help them to deicide in the career path and for the future.
									</p>
								</div>
							</div>
							<div class="single-popular-carusel">
								<div class="thumb-wrap relative">
									<div class="thumb relative">
										<div class="overlay overlay-bg"></div>	
										<img class="img-fluid" src="images/Pictures10.1.png"alt="">
									</div>									
								</div>
								<div class="details">
									<a href="#">
										<h4>
										October:Scouting Month & Costume Parade
										</h4>
									</a>
									<p>
									The Students as a Boy Scout and Girl Scout of the Phillipines movement and the event Costume Parade party for Students.
									</p>
								</div>
							</div>	
							<div class="single-popular-carusel">
								<div class="thumb-wrap relative">
									<div class="thumb relative">
										<div class="overlay overlay-bg"></div>	
										<img class="img-fluid" src="images/Pictures11.1.png"  alt="">
									</div>								
								</div>
								<div class="details">
									<a href="#">
										<h4>
										November: Sportsfest, Thanksgiving
										</h4>
									</a>
									<p>
									Spirit Week a youthful spirit,Sportsfest Value of teamwork & sportsmanship, Foundation Day Activities.
								</div>
							</div>	
							<div class="single-popular-carusel">
								<div class="thumb-wrap relative">
									<div class="thumb relative">
										<div class="overlay overlay-bg"></div>	
										<img class="img-fluid" src="images/Pictures12.png"  alt="">
									</div>								
								</div>
								<div class="details">
									<a href="#">
										<h4>
											December: YearEnd Party
										</h4>
									</a>
									<p>
									This is a celebration to end a Blessed year Gift-giving is the time where we enjoy with Friends & Families.
									</p>
								</div>
							</div>	
							<div class="single-popular-carusel">
								<div class="thumb-wrap relative">
									<div class="thumb relative">
										<div class="overlay overlay-bg"></div>	
										<img class="img-fluid" src="images/Pictures13.png"  alt="">
									</div>									
								</div>
								<div class="details">
									<a href="#">
										<h4>
										January: Bible Month & Educational Tour
										</h4>
									</a>
									<p>
									For most of us, the idea of astronomy is something we directly connect to “stargazing”, telescopes and seeing magnificent displays in the heavens.
									</p>
								</div>
							</div>
							<div class="single-popular-carusel">
								<div class="thumb-wrap relative">
									<div class="thumb relative">
										<div class="overlay overlay-bg"></div>	
										<img class="img-fluid" src="images/Pictures14.png"  alt="">
									</div>								
								</div>
								<div class="details">
									<a href="#">
										<h4>
										February: Pajama Night, Tea Party, Picnic Day
										</h4>
									</a>
									<p>
									Pajama Night for Puberty Talks, Tea Party Aims to teach table manner, Picnic Day for outdoors.
									</p>
								</div>
							</div>
						<!-- </div> -->
						<div class="single-popular-carusel">
								<div class="thumb-wrap relative">
									<div class="thumb relative">
										<div class="overlay overlay-bg"></div>	
										<img class="img-fluid" src="images/Pictures15.png"   alt="">
									</div>								
								</div>
								<div class="details">
									<a href="#">
										<h4>
										March: Moving Up Ceremony
										</h4>
									</a>
									<p>
									This event is held to commemorate the completion of the child's level and recognize the significance of moving on to the next level.
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>	
			</section>

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