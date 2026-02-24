<!doctype html>
<?php  require_once ("db.php");
include 'title.php';
?>




<html class="no-js" lang="en">

    <head>

        <link rel="stylesheet" type="text/css" href="../assets/stylesheet.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@latest/dist/css/splide.min.css">

        <script>



			function projects(url) {



			    $.ajax({

			        url: url,

			        type: "GET",

			        data: { rowcount: $("#rowcount").val() },

			        success: function(data) {

			            $(".pagination").html(data);

			           

			        },

			        error: function() { }

			    });

			   

			}



			function products(url) {



			    $.ajax({

			        url: url,

			        type: "GET",

			        data: { rowcount: $("#rowcount").val() },

			        success: function(data) {

			            $(".pagination").html(data);



			        },

			        error: function() { }

			    });



			}



			function services(url) {



			    $.ajax({

			        url: url,

			        type: "GET",

			        data: { rowcount: $("#rowcount").val() },

			        success: function(data) {

			            $(".pagination").html(data);



			        },

			        error: function() { }

			    });



			}





			function formSubmit(value)
			{

				document.forms[0].id.value = value[0];
				document.forms[0].name.value = value[1];
				document.forms[0].submit();

			}









			

		</script>





        <!-- Removed by WebCopy --><!--<base href="https://worldhomedepot.com/">--><!-- Removed by WebCopy --><!--[if lte IE 6]></base><![endif]-->

        <meta charset="utf-8">

        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title></title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
        <link rel="shortcut icon" href="assets/headerfooter/header_logo.png" type="image/x-icon">
        <link rel="apple-touch-icon" href="assets/headerfooter/header_logo.png">
        <link rel="apple-touch-icon" href="assets/headerfooter/header_logo.png">

        <meta name="keywords" content="">

        

        <meta name="twitter:site" content="">

        

        <meta name="msapplication-TileColor" content="#">

        <meta name="msapplication-square70x70logo" content="">

        <meta name="msapplication-square150x150logo" content="">

        <meta name="msapplication-wide310x150logo" content="">

        <meta name="msapplication-square310x310logo" content="">

        





        

            

                <meta property="og:image" content="">

                

                    <meta name="description" content="">

                    <meta property="og:description" content="">

                

            

            <!--<meta property="og:title" content="About Us">-->

            <meta property="og:url" content="https://thesentinelautomation.com/">

        

        

        

        

        <meta property="og:site_name" content="The Sentinel Automations">

        <meta property="og:type" content="website">

        <meta name="application-name" content="The Sentinel Automations">

        



        

        

        <!-- Ionicon -->

        <link rel="stylesheet" href="ionicons/1.5.2/css/ionicons.min.css">

        

        <!-- Font Awesome -->

        <link rel="stylesheet" href="releases/v5.8.2/css/all.css">



        <!-- Slick -->

        <link rel='stylesheet' href='ajax/libs/animate.css/3.7.2/animate.min.css'>

        <link rel="stylesheet" href="jquery.slick/1.3.15/slick.css">




        <!-- Remodal -->

        <link rel="stylesheet" href="ajax/libs/remodal/1.0.6/remodal.css">

        <link rel="stylesheet" href="ajax/libs/remodal/1.0.6/remodal-default-theme.min.css">



        <!-- Light Gallery -->

        <link rel="stylesheet" href="ajax/libs/lightgallery/1.6.4/css/lightgallery.min.css">

        

        <!-- SweetAlert -->

        <link rel="stylesheet" href="ajax/libs/sweetalert/1.1.3/sweetalert.min.css">



        

        <link rel="stylesheet" href="swiper%408.4.2/swiper-bundle.min.css">





        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        

        <link rel="stylesheet" href="_resources/themes/main/fonts/fonts/stylesheet.css">

        <link rel="stylesheet" href="_resources/themes/main/assets/app.min.css">



        <script src="http://code.jquery.com/jquery-2.1.1.js"></script>

        

        <!--[if lt IE 9]>

        <script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>

        <![endif]-->


        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">

        <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
        <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

        <style>
            .img-hldr img {
                width: 550px;
                height: 600px;
            }

            /* For medium screens */
            @media only screen and (max-width: 768px) {
                .img-hldr img {
                    width: 600px;
                    height: 638px;
                }
            }

            /* For small screens */
            @media only screen and (max-width: 576px) {
                .img-hldr img {
                    width: 400px;
                    height: 425px;
                }
            }

            /* For extra small screens */
            @media only screen and (max-width: 480px) {
                .img-hldr img {
                    width: 200px;
                    height: 250px;
                }

            }

            .menu-link {
                color: #808080;
            }

        </style>

    </head>

    <body>

        <!--[if lt IE 8]>

        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>

        <![endif]-->

        

        

        

<div class="hdr-frame">

	<div class="hdr-wrapper">
		<div class="menu-button__hldr">
			<div class="menu-btn">
                <button class="navbar-toggler" type="button" data-mdb-collapse-init
                        data-mdb-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent"
                        aria-expanded="false" aria-label="Toggle navigation" style="border: none;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="white" class="bi bi-list" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5"/>
                    </svg>
                </button>
			</div>
			<div class="menu-text">
				<p>Menu</p>
			</div>
		</div>
		<div class="hdr-right__hldr">
			<div class="hdr-right__link">
				<a href="request-appointment.php">REQUEST APPOINTMENT</a>
			</div>
		</div>
	</div>

</div>

<div class="hdr-frame white">
	<div class="hdr-wrapper">
		<div class="menu-button__hldr">
			<div class="menu-btn my-auto">
                <button class="navbar-toggler" type="button" data-mdb-collapse-init
                        data-mdb-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent"
                        aria-expanded="false" aria-label="Toggle navigation" style="border: none; background-color: transparent">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="#162747" class="bi bi-list" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5"/>
                    </svg>
                </button>
			</div>
			<div class="menu-text my-auto">
				<p>Menu</p>
			</div>
		</div>
		<div class="hdr-right__hldr">
			<div class="hdr-right__link">
				<a href="request-appointment.php">
                    REQUEST APPOINTMENT
                </a>
			</div>
		</div>

	</div>
	<div class="hdr-logo">
		<a href="index.php">
<!--			<img src="../assets/SVG/" alt="" style="width: 206px; height: 32px;">-->
		</a>
	</div>
</div>



<div class="menu-hldr">
	<div class="hdr-frame">
		<div class="hdr-wrapper">
			<div class="menu-button__hldr">
				<div class="close-text menu-close">
					<p>CLOSE</p>
				</div>
			</div>

			<div class="hdr-right__hldr">
				<div class="hdr-right__link">
					<a href="request-appointment.php">REQUEST APPOINTMENT</a>
				</div>
			</div>

		</div>

	</div>

	<div class="menu-hldr__wrapper">
        <div class="img-hldr p-5 mx-auto d-flex align-items-center justify-content-center">
            <img src="assets/SVG/sentinellogotext-gray.svg">
        </div>

        <div class="menu-container">
            <div class="menu-link">
                <a class="text" data-text="Home" href="index.php">Home</a>
            </div>
            <div class="menu-link link">
                <a class="text" data-text="Projects" href="projects.php">Projects</a>
            </div>
            <div class="menu-link">
                <a class="text" data-text="Systems & Services " href="products.php">Systems & Services </a>
            </div>
            <div class="menu-link">
                <a class="text" data-text="About Us" href="about.php">About Us</a>
            </div>
            <div class="menu-link link">
                <a class="text" data-text="Contact Us" href="contact-us.php">Contact Us</a>
            </div>
		</div>

		<div class="mobile-navlink">
			<div class="m-navlink">
				<a href="request-appointment.php">Request Appointment</a>
			</div>
		</div>

		

		<div class="social-hldr">
			<div class="social-info">
				<a href="https://www.facebook.com/TheSentinelAASSI/">
                    <i class="fab fa-facebook"></i>
				</a>
			</div>
		</div>

		

	</div>

</div>



    <div id="scrollbar">

        <div class="main">