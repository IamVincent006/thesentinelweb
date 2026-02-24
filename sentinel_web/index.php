<?php 
include "template/header.php"; 

//////////////////BRAND/////////////////////////////////
$sql = "SELECT * FROM brand";
$result = $conn->query($sql);
//////////////////Clients/////////////////////////////////
$sql_clients = "SELECT * FROM clients";
$result_clients = $conn->query($sql_clients);
/////////////////PROJECT///////////////////////////////

?>
<style>
/* ─────────────────────────────────────────────────────
   1. HERO SECTION (hm-frame1)
   ───────────────────────────────────────────────────── */

/* Subtle gradient overlay on hero background image */
.hm-frame1 .hm-frame1__vidbg::after {
    content: '';
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: linear-gradient(
        160deg,
        rgba(10, 20, 40, 0.75) 0%,
        rgba(22, 39, 71, 0.45) 50%,
        rgba(22, 39, 71, 0.25) 100%
    );
    z-index: 1;
    pointer-events: none;
}

/* Ensure hero text sits above the overlay */
.hm-frame1 .frm-cntnr {
    position: relative;
    z-index: 2;
}

/* Company name — enhance readability */
.hm-frame1__desc h2.clr--white {
    text-shadow: 0 2px 20px rgba(0, 0, 0, 0.35);
    letter-spacing: -0.3px;
}

/* Tagline */
.hm-frame1__desc h4.clr--white {
    opacity: 0.92;
    text-shadow: 0 1px 12px rgba(0, 0, 0, 0.3);
}

/* Description paragraph */
.hm-frame1__desc p.clr--white {
    opacity: 0.88;
    text-shadow: 0 1px 8px rgba(0, 0, 0, 0.2);
    max-width: 720px;
}

/* Smooth reveal of hero content after preloader */
.hm-frame1 .vertical-align {
    opacity: 0;
    transform: translateY(25px);
    animation: heroContentReveal 1s ease 2.2s forwards;
}

@keyframes heroContentReveal {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}


/* ─────────────────────────────────────────────────────
   2. ABOUT SECTION (hm-frame2) — Vision, Mission, 
      Who We Are, Why Choose Us
   ───────────────────────────────────────────────────── */
.hm-frame2 {
    background: #fff;
}

.hm-frame2__content {
    position: relative;
    z-index: 2;
}

/* Section headers — green accent underline */
.hm-frame2 .abt-frame1__header h2 {
    color: #12253f;
    position: relative;
    display: inline-block;
    padding-bottom: 14px;
}

.hm-frame2 .abt-frame1__header h2::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 50px;
    height: 3px;
    background: linear-gradient(90deg, #162747, #1c385f);
    border-radius: 2px;
}

/* Paragraph text refinement */
.hm-frame2 .clr--black--600 p,
.hm-frame2 p.clr--black--600 {
    color: #4a4a4a;
    line-height: 1.85;
}

/* "Why Choose Us" list — modern checkmark bullets */
.hm-frame2 .clr--black--600 ul {
    padding: 0;
    margin: 0;
}

.hm-frame2 .clr--black--600 ul li {
    padding: 16px 0 16px 42px;
    color: #444;
    border-bottom: 1px solid #f0f0f0;
    margin-bottom: 0;
    transition: all 0.3s ease;
}

.hm-frame2 .clr--black--600 ul li:last-child {
    border-bottom: none;
}

/* Override the default square bullet from app.min.css */
.hm-frame2 .clr--black--600 ul li:before {
    content: '\2713';
    background-color: #162747;
    color: #fff;
    width: 22px;
    height: 22px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 11px;
    font-weight: 700;
    top: 16px;
}

.hm-frame2 .clr--black--600 ul li:hover {
    padding-left: 50px;
    color: #12253f;
    background: #f8fafb;
}

/* KNOW MORE button — modern pill style */
.hm-frame2__content .readmore-btn {
    border-bottom: none;
    padding-bottom: 0;
    margin-top: 15px;
    margin-bottom: 45px;
}

.hm-frame2__content .readmore-btn a {
    display: inline-block;
    padding: 12px 36px;
    background: #12253f;
    color: #fff;
    border-radius: 50px;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1.5px;
    transition: all 0.35s ease;
    border: 2px solid #12253f;
}

.hm-frame2__content .readmore-btn:hover {
    border-color: transparent;
}

.hm-frame2__content .readmore-btn a:hover {
    background: transparent;
    color: #12253f;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(18, 37, 63, 0.15);
}

/* Smooth scroll reveal for animate-up elements */
.hm-frame2 .animate-up {
    transition: opacity 0.7s ease, transform 0.7s ease;
}


/* ─────────────────────────────────────────────────────
   3. BRANDS & CLIENTS (hm-frame4) — FIXED
   No .container targeting — only .brand-item level
   ───────────────────────────────────────────────────── */
.hm-frame4 {
    padding: 75px 0;
    background: #f9fafb;
}

/* Alternate bg for the second hm-frame4 (Clients) */
.hm-frame4 ~ .hm-frame4 {
    background: #fff;
}

/* Section title with underline accent */
.hm-frame4 .hm-frame4__title h2 {
    color: #12253f;
    position: relative;
    display: inline-block;
    padding-bottom: 14px;
}

.hm-frame4 .hm-frame4__title h2::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 50px;
    height: 3px;
    background: linear-gradient(90deg, #162747, #1c385f);
    border-radius: 2px;
}

/* Brand/Client images — grayscale to color on hover */
.hm-frame4 .brand-slider .brand-item img {
    filter: grayscale(80%);
    opacity: 0.65;
    transition: all 0.4s ease;
}

.hm-frame4 .brand-slider .brand-item:hover img {
    filter: grayscale(0%);
    opacity: 1;
    transform: scale(1.06);
}


/* ─────────────────────────────────────────────────────
   4. PROJECTS (hm-frame6)
   ───────────────────────────────────────────────────── */
.hm-frame6 {
    padding: 80px 0;
    background: #fff;
}

.hm-frame6 .hm-frame6__top h2 {
    color: #12253f;
}

/* View All button — pill outline style */
.hm-frame6 .viewall {
    border-bottom: none;
    padding-bottom: 0;
}

.hm-frame6 .viewall a {
    display: inline-block;
    padding: 10px 28px;
    border: 2px solid #12253f;
    color: #12253f;
    border-radius: 50px;
    font-size: 12px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 1.2px;
    transition: all 0.35s ease;
}

.hm-frame6 .viewall a:hover {
    background: #12253f;
    color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(18, 37, 63, 0.2);
}

/* Project cards — rounded, lifted hover, always-visible titles */
.hm-frame6 .project-holder .project-container {
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.45s ease;
}

.hm-frame6 .project-holder .project-container:hover {
    transform: translateY(-6px) scale(1.02);
    box-shadow: 0 18px 45px rgba(0, 0, 0, 0.15);
}

.hm-frame6 .project-holder .project-container .gradient {
    opacity: 0.7;
    background: linear-gradient(
        to top,
        rgba(10, 20, 40, 0.85) 0%,
        rgba(10, 20, 40, 0.15) 55%,
        transparent 100%
    );
    border-radius: 12px;
    transition: opacity 0.4s ease;
}

.hm-frame6 .project-holder .project-container:hover .gradient {
    opacity: 1;
}

/* Always show project title text */
.hm-frame6 .project-holder .project-container .project-title {
    opacity: 1;
    transform: translateY(0);
}

.hm-frame6 .project-holder .project-container .project-title h6 {
    font-weight: 700;
    text-shadow: 0 1px 6px rgba(0, 0, 0, 0.3);
    line-height: 1.5;
}


/* ─────────────────────────────────────────────────────
   5. RESPONSIVE
   ───────────────────────────────────────────────────── */
@media (max-width: 1024px) {
    .hm-frame4 {
        padding: 50px 0;
    }
    .hm-frame6 {
        padding: 50px 0;
    }
    .hm-frame6 .project-holder .project-container {
        border-radius: 8px;
    }
    .hm-frame6 .project-holder .project-container .gradient {
        border-radius: 8px;
    }
}
</style>


        <div class="preload">
            <div class="preload-wrapper">
                <div class="background"></div>
                <img src="./assets/SVG/sentinellogotext-white.svg" alt="" style="object-fit: cover;">
            </div>
        </div>
        

<section class="hm-frame1">
	<div class="hm-frame1__vidbg">

        <img src="./assets/cover-photo.png" alt="" style="object-fit: initial; filter: blur(3px)">

	</div>
	
	<div class="frm-cntnr width--85">
		<div class="vertical-parent">
			<div class="vertical-align mx-3">
				<div class="hm-frame1__eyebrow">
					<h4 class="clr--white"></h4>
				</div>
				<div class="hm-frame1__desc">
                    <h2 class="clr--white fw-bolder ">The Sentinel Automation and  Security Solutions Inc.</h2>
                    <div class="spacing"></div>
					<h4 class="clr--white fw-bold ">"Engineering Safety and Security."</h4>
                    <p class="clr--white mt-3" style="font-size: 1.1rem; line-height: 1.6;">
                        is a Philippine based systems integrator specializing in security, automation, and building technologies. We deliver innovative, compliant, and reliable solutions tailored to our clients' operational needs.
                    </p>
				</div>

				<div style="display:none;" -lg-size="1280-720"id="video">
					<video class="lg-video-object lg-html5" controls=""   preload="none">
						
						<source src="assets/Uploads/video.mp4" type="video/mp4">
						
					Your browser does not support HTML5 video.
					</video>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="hm-frame2">
	<div class="hm-frame2__bg" style="background-image: url('assets/homepage/ai.png');"></div>
	<div class="hm-frame2__bg" style="background-image: url('');"></div>
	<div class="frm-cntnr width--75 align-c">
		<div class="hm-frame2__content w-wrapper">

            <div class="abt-frame1__header">
                <h2 class="clr--gray--600 fw-bolder">Vision</h2>
            </div>

			<div class="clr--black--600 animate-up">
				<p>Provide efficient solution that satisfy the client requirements in compliance to the engineering and global standards.</p><p>&nbsp;</p>
			</div>

            <div class="abt-frame1__header">
                <h2 class="clr--gray--600 fw-bolder">Mission</h2>
            </div>

            <div class="clr--black--600 animate-up">
                <p>To be recognized as the leading systems integrator of security systems in the Philippines.</p><p>&nbsp;</p>
            </div>


            <div class="abt-frame1__header">
                <h2 class="clr--gray--600 fw-bolder">Who We Are</h2>
            </div>

			<p class="clr--black--600 animate-up">The Sentinel is a system integrator company with IT, electronics and electrical engineering
                specializations, designed to meet the clients' requirement while abiding to standard compliance.
                With the fast global modernization, the necessity for security arises along with safety. Our team of experts, key players and well rounded personnel with highly adaptive skills is the best asset of our company. We deliver quality workmanship for both software and hardware installation and integration. Having an in depth
                expertise in this technology sets us as highly preferred system integrator in the  industry.</p>
			<div class="readmore-btn animate-up">
				<a href="about.php">KNOW MORE </a>
			</div>

            <div class="abt-frame1__header">
                <h2 class="clr--gray--600 fw-bolder">Why Choose Us?</h2>
            </div>

            <div class="clr--black--600 animate-up">
                <ul style="display: inline-block; text-align: left;">
                    <li>Licensed and accredited systems integrator in the Philippines</li>
                    <li>Extensive experience in commercial, industrial, and government projects</li>
                    <li>Expertise in system integration and engineering compliance</li>
                    <li>Trusted by leading developers, corporations, and institutions</li>
                    <li>End to end services from design to maintenance</li>
                </ul>
            </div>
		</div>  
	</div>
	<div class="leaf-trigger">
		<div class="leaf1"></div>
		<div class="leaf2"></div>
	</div>
</section>


    <section class="hm-frame4">
        <div class="frm-cntnr width--90">
            <div class="hm-frame4__title align-c animate-up">
                <h2 class="clr--blue">Brands We Trust</h2>
            </div>

            <div class="brand-slider animate-up">
                <?php while ($row = mysqli_fetch_array($result)) { ?>
                    <div class="brand-item">
                        <div class="container">
                            <img src="<?= $row['brand_image'] ?>" alt="<?= $row['brand_name'] ?>" style="object-fit: contain" class="p-3">
                            </a>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="mbrand-slider">
                <?php while ($row = mysqli_fetch_array($result)) { ?>
                    <div class="brand-hldr">
                        <div class="inner">
                            <img src="<?= $row['brand_image'] ?>" alt="<?= $row['brand_name'] ?>" style="object-fit: contain">
                        </div>
                    </div>
                <?php } ?>
            </div>

            <div class="slick-arrows">
                <div class="left-arrow arrow">
                    <img src="_resources/themes/main/images/r-arrow.png" alt="">
                </div>
                <div class="right-arrow arrow">
                    <img src="_resources/themes/main/images/r-arrow.png" alt="">
                </div>
            </div>
        </div>
    </section>

    <section class="hm-frame4">
        <div class="frm-cntnr width--90">
            <div class="hm-frame4__title align-c animate-up">
                <h2 class="clr--blue">Our Valued Clients</h2>
            </div>

            <div class="brand-slider animate-up">
                <?php while ($row = mysqli_fetch_array($result_clients)) { ?>
                    <div class="brand-item">
                        <div class="container">
                            <img src="<?= $row['client_image'] ?>" alt="<?= $row['client_name'] ?>" class="p-5">
                        </div>
                    </div>
                <?php } ?>
            </div>
            <div class="mbrand-slider">
                <?php while ($row = mysqli_fetch_array($result_clients)) { ?>
                    <div class="brand-hldr">
                        <div class="inner ">
                            <img src="<?= $row['client_image'] ?>" alt="<?= $row['client_name'] ?>">
                        </div>
                    </div>
                <?php } ?>
            </div>

            <div class="slick-arrows">
                <div class="left-arrow arrow">
                    <img src="_resources/themes/main/images/r-arrow.png" alt="">
                </div>
                <div class="right-arrow arrow">
                    <img src="_resources/themes/main/images/r-arrow.png" alt="">
                </div>
            </div>
        </div>
    </section>


<section class="hm-frame6">
	<div class="frm-cntnr">
		<div class="hm-frame6__top">
			<h2 class="animate-up">Turn-key Solutions and Special Projects</h2>
			<div class="viewall btn animate-up">
				<a class="clr--blue" href="projects.php">VIEW ALL PROJECTS</a>
			</div>
		</div>
		
		<div class="project-holder">
			
			<div class="project-container">
				<img src="assets/projectpage/axistower1.jpg" alt="">
				<div class="gradient"></div>
				<div class="project-title">
					<h6>
						Filinvest Axis Towers 1,2,3,4 <br>
Turnstile Access and DOAS Elevator Control System Integration
					</h6>
				</div>
			</div>
			
			<div class="project-container">
				<img src="assets/projectpage/fcc.jpg" alt="">
				<div class="gradient"></div>
				<div class="project-title">
					<h6>
						Filinvest Cyberzone Cebu 1 & 2<br>
Turnstile Access and DFRS Multi Zone Elevator Control System Integration
					</h6>
				</div>
			</div>
			
			<div class="project-container">
				<img src="assets/projectpage/nextower.jpg" alt="">
				<div class="gradient"></div>
				<div class="project-title">
					<h6>
						Nex Tower<br>
Door Access Control System and Revolving Door
					</h6>
				</div>
			</div>
			
		</div>
		
		<div class="viewall btn mobile">
			<a class="clr--blue" href="projects.php">VIEW ALL PROJECTS</a>
		</div>
	</div>
</section>

        </div>

        <script type="text/javascript">
            var pageID = 'HomePage',
            baseHref = 'localhost',
            themeDir = '/_resources/themes/main';
        </script>
        
<?php include "template/footer.php"; ?>