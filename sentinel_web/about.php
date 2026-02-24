<?php 
include "template/header.php"; 

//////////////////BRAND/////////////////////////////////
$aboutsql = "SELECT * FROM aboutus";
$aboutresult = $conn->query($aboutsql);
$aboutrow = mysqli_fetch_array($aboutresult);

$timelinesql = "SELECT * FROM timeline ORDER BY year ASC";
$timelineresult = $conn->query($timelinesql);

// Store timeline data in array for reuse
$timelineData = [];
while ($row = mysqli_fetch_array($timelineresult)) {
    $timelineData[] = $row;
}
$totalTimeline = count($timelineData);
?>

<style>
/* ─────────────────────────────────────────────────────
   1. HERO (abt-frame1)
   ───────────────────────────────────────────────────── */
.abt-frame1 {
    position: relative;
}

.abt-frame1 .abt-frame1__img-hldr::after {
    content: '';
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: linear-gradient(
        135deg,
        rgba(10, 18, 35, 0.80) 0%,
        rgba(22, 39, 71, 0.50) 60%,
        rgba(22, 39, 71, 0.30) 100%
    );
    z-index: 1;
}

.abt-frame1 .abt-frame1__content {
    position: relative;
    z-index: 2;
}

.abt-frame1__header h2 {
    letter-spacing: -0.3px;
    position: relative;
    display: inline-block;
    padding-bottom: 12px;
}

.abt-frame1__header h2::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 45px;
    height: 3px;
    background: #fff;
    border-radius: 2px;
}

.abt-frame1__desc p {
    line-height: 1.85;
    opacity: 0.92;
}

.abt-frame1 .abt-btn a {
    display: inline-block;
    padding: 14px 32px;
    border: 2px solid rgba(255,255,255,0.7);
    border-radius: 50px;
    color: #fff;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 1.5px;
    text-transform: uppercase;
    transition: all 0.35s ease;
    text-decoration: none;
}

.abt-frame1 .abt-btn a:hover {
    background: #fff;
    color: #162747;
    border-color: #fff;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.2);
}


/* ─────────────────────────────────────────────────────
   2. STICKY TAB NAVIGATION
   ───────────────────────────────────────────────────── */
.about-tabs-nav {
    background: #fff;
    border-bottom: 1px solid #e9ecef;
    padding: 0;
    position: sticky;
    top: 0;
    z-index: 100;
    box-shadow: 0 2px 12px rgba(0,0,0,0.04);
}

.about-tabs-nav .nav-tabs {
    border: none;
    justify-content: center;
    gap: 0;
    max-width: 900px;
    margin: 0 auto;
}

.about-tabs-nav .nav-tabs .nav-link {
    border: none;
    border-bottom: 3px solid transparent;
    border-radius: 0;
    color: #7a8a9e;
    font-size: 13px;
    font-weight: 700;
    letter-spacing: 1.2px;
    text-transform: uppercase;
    padding: 20px 30px;
    transition: all 0.3s ease;
    background: transparent;
}

.about-tabs-nav .nav-tabs .nav-link:hover {
    color: #12253f;
    border-bottom-color: rgba(22,39,71,0.2);
}

.about-tabs-nav .nav-tabs .nav-link.active {
    color: #12253f;
    border-bottom-color: #162747;
    background: transparent;
}

.about-tabs-nav .nav-tabs .nav-link i {
    margin-right: 8px;
    font-size: 14px;
}

.about-tab-content .tab-pane {
    animation: tabFadeIn 0.5s ease;
}

@keyframes tabFadeIn {
    from { opacity: 0; transform: translateY(15px); }
    to   { opacity: 1; transform: translateY(0); }
}


/* ─────────────────────────────────────────────────────
   3. TAB 1: OVERVIEW (Mission + Vision)
   ───────────────────────────────────────────────────── */
.overview-section {
    padding: 70px 0 80px;
    background: #f8f9fb;
}

.overview-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 40px;
    max-width: 1100px;
    margin: 0 auto;
    padding: 0 20px;
}

.overview-card {
    background: #fff;
    border-radius: 16px;
    padding: 50px 45px;
    position: relative;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0,0,0,0.04);
    transition: all 0.4s ease;
    border: 1px solid #eef0f4;
}

.overview-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 16px 40px rgba(22,39,71,0.10);
}

.overview-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 4px;
    background: linear-gradient(90deg, #162747, #1c3a5f);
}

.overview-card .ov-icon {
    width: 56px;
    height: 56px;
    border-radius: 14px;
    background: linear-gradient(135deg, #162747, #1c3a5f);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 24px;
}

.overview-card .ov-icon i {
    color: #fff;
    font-size: 22px;
}

.overview-card .ov-label {
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: #162747;
    margin-bottom: 10px;
}

.overview-card h3 {
    font-size: 26px;
    font-weight: 800;
    color: #12253f;
    margin-bottom: 18px;
    line-height: 1.3;
}

.overview-card p {
    color: #5a6a7e;
    font-size: 15px;
    line-height: 1.85;
    margin: 0;
}

/* Who We Are full-width card */
.overview-who {
    max-width: 1100px;
    margin: 40px auto 0;
    padding: 0 20px;
}

.overview-who .who-card {
    background: #162747;
    border-radius: 16px;
    padding: 50px 55px;
    color: #fff;
    position: relative;
    overflow: hidden;
}

.overview-who .who-card::after {
    content: '';
    position: absolute;
    top: -50%; right: -15%;
    width: 400px; height: 400px;
    border-radius: 50%;
    background: rgba(255,255,255,0.03);
}

.overview-who .who-card h3 {
    font-size: 22px;
    font-weight: 800;
    color: #fff;
    margin-bottom: 16px;
    position: relative;
    display: inline-block;
    padding-bottom: 14px;
}

.overview-who .who-card h3::after {
    content: '';
    position: absolute;
    bottom: 0; left: 0;
    width: 40px; height: 3px;
    background: rgba(255,255,255,0.4);
    border-radius: 2px;
}

.overview-who .who-card p {
    color: rgba(255,255,255,0.82);
    font-size: 15px;
    line-height: 1.85;
    margin: 0;
    max-width: 850px;
}

.overview-who .who-card .who-cta {
    margin-top: 28px;
}

.overview-who .who-card .who-cta a {
    display: inline-block;
    padding: 12px 30px;
    border: 2px solid rgba(255,255,255,0.35);
    border-radius: 50px;
    color: #fff;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 1.2px;
    text-transform: uppercase;
    text-decoration: none;
    transition: all 0.3s ease;
}

.overview-who .who-card .who-cta a:hover {
    background: #fff;
    color: #162747;
    border-color: #fff;
}


/* ─────────────────────────────────────────────────────
   4. TAB 2: HORIZONTAL SLIDER TIMELINE
   ───────────────────────────────────────────────────── */
.timeline-section {
    padding: 70px 0 60px;
    background: #fff;
    overflow: hidden;
}

.timeline-section .section-header {
    text-align: center;
    margin-bottom: 50px;
}

.timeline-section .section-header h2 {
    font-size: 32px;
    font-weight: 800;
    color: #12253f;
    margin-bottom: 12px;
}

.timeline-section .section-header p {
    color: #7a8a9e;
    font-size: 15px;
}

/* ── Main slider wrapper ── */
.tl-slider-wrapper {
    position: relative;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 70px;
}

/* ── Left / Right arrow buttons ── */
.tl-slider-wrapper .tl-arrow {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    z-index: 10;
    width: 50px;
    height: 50px;
    border-radius: 50%;
    border: 2px solid #162747;
    background: #fff;
    color: #162747;
    font-size: 18px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(0,0,0,0.08);
}

.tl-slider-wrapper .tl-arrow:hover:not(:disabled) {
    background: #162747;
    color: #fff;
    box-shadow: 0 6px 22px rgba(22,39,71,0.25);
}

.tl-slider-wrapper .tl-arrow:disabled {
    opacity: 0.3;
    cursor: not-allowed;
    border-color: #b0b8c5;
    color: #b0b8c5;
}

.tl-slider-wrapper .tl-arrow.tl-prev {
    left: 5px;
}

.tl-slider-wrapper .tl-arrow.tl-next {
    right: 5px;
}

/* ── Viewport (overflow hidden mask) ── */
.tl-slider-viewport {
    overflow: hidden;
    width: 100%;
    position: relative;
}

/* ── The horizontal rail ── */
.tl-slider-rail {
    display: flex;
    will-change: transform;
    /* transition is set dynamically via JS */
}

/* ── Each slide ── */
.tl-slide {
    flex: 0 0 calc(100% / 3);
    padding: 0 15px;
    box-sizing: border-box;
}

/* ── Card inside each slide ── */
.tl-slide-inner {
    display: flex;
    flex-direction: column;
    align-items: center;
    height: 100%;
}

/* ── Year circle — ABOVE the line with white mask ring ── */
.tl-slide-inner .tl-year {
    width: 72px;
    height: 72px;
    border-radius: 50%;
    background: #fff;
    border: 3px solid #162747;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    font-weight: 800;
    color: #162747;
    position: relative;
    z-index: 5;
    transition: all 0.35s ease;
    flex-shrink: 0;
    box-shadow: 0 0 0 6px #fff;
}

.tl-slide:hover .tl-year {
    background: #162747;
    color: #fff;
    transform: scale(1.1);
    box-shadow: 0 0 0 6px #fff, 0 6px 20px rgba(22,39,71,0.25);
}

/* ── Horizontal line — BEHIND circles ── */
.tl-slider-line {
    position: absolute;
    top: 36px;
    left: 70px;
    right: 70px;
    height: 3px;
    background: linear-gradient(90deg, #d8dde5, #162747 30%, #162747 70%, #d8dde5);
    border-radius: 2px;
    z-index: 0;
    pointer-events: none;
}

/* Connector line from circle to card */
.tl-slide-inner .tl-connector {
    width: 2px;
    height: 28px;
    background: #d0d5dd;
    flex-shrink: 0;
}

/* Content card */
.tl-slide-inner .tl-card {
    background: #f8f9fb;
    border-radius: 14px;
    overflow: hidden;
    width: 100%;
    transition: all 0.4s ease;
    border: 1px solid #eef0f4;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.tl-slide:hover .tl-card {
    transform: translateY(-4px);
    box-shadow: 0 12px 30px rgba(0,0,0,0.08);
    border-color: #d0d8e4;
}

/* MODIFIED THIS CLASS TO SHOW FULL IMAGE */
.tl-card-img {
    width: 100%;
    height: 180px;
    background-size: contain; /* Changed from cover to contain */
    background-repeat: no-repeat; /* Ensure the image doesn't tile */
    background-position: center;
    position: relative;
    flex-shrink: 0;
    cursor: pointer; /* Added for Lightbox */
    transition: opacity 0.3s ease;
}

/* Added for Lightbox: Hover overlay icon */
.tl-card-img::before {
    content: '\f00e'; /* FontAwesome search-plus icon */
    font-family: 'Font Awesome 5 Free'; 
    font-weight: 900;
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) scale(0.5);
    color: white;
    font-size: 32px;
    opacity: 0;
    z-index: 2;
    transition: all 0.3s ease;
}

.tl-card-img:hover::before {
    opacity: 1;
    transform: translate(-50%, -50%) scale(1);
}

.tl-card-img::after {
    content: '';
    position: absolute;
    bottom: 0; left: 0; right: 0;
    height: 100%; 
    background: linear-gradient(to top, rgba(0,0,0,0.4), transparent);
    transition: background 0.3s ease;
}

.tl-card-img:hover::after {
    background: rgba(22, 39, 71, 0.4); /* Subtle blue tint on hover */
}

.tl-card-body {
    padding: 20px 22px 24px;
    flex: 1;
}

.tl-card-body p {
    color: #5a6a7e;
    font-size: 13.5px;
    line-height: 1.75;
    margin: 0;
}

/* ── Dot indicators ── */
.tl-dots {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-top: 35px;
}

.tl-dots .tl-dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: #d0d5dd;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    padding: 0;
}

.tl-dots .tl-dot.active {
    background: #162747;
    width: 28px;
    border-radius: 5px;
}

.tl-dots .tl-dot:hover:not(.active) {
    background: #9aa5b4;
}

/* ── Counter ── */
.tl-counter {
    text-align: center;
    margin-top: 14px;
    font-size: 13px;
    color: #9aa5b4;
    font-weight: 600;
    letter-spacing: 1px;
}

.tl-counter .tl-counter-current {
    color: #162747;
    font-weight: 800;
}


/* ─────────────────────────────────────────────────────
   5. TAB 3: TECHNICAL STRUCTURE
   ───────────────────────────────────────────────────── */
.techstructure-section {
    padding: 70px 0 80px;
    background: #f8f9fb;
}

.techstructure-section .section-header {
    text-align: center;
    margin-bottom: 50px;
}

.techstructure-section .section-header h2 {
    font-size: 32px;
    font-weight: 800;
    color: #12253f;
    margin-bottom: 12px;
}

.techstructure-section .section-header p {
    color: #7a8a9e;
    font-size: 15px;
}

.tech-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 30px;
    max-width: 1100px;
    margin: 0 auto;
    padding: 0 20px;
}

.tech-card {
    background: #fff;
    border-radius: 16px;
    padding: 45px 40px;
    text-align: center;
    position: relative;
    overflow: hidden;
    border: 1px solid #eef0f4;
    transition: all 0.4s ease;
}

.tech-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 16px 40px rgba(22,39,71,0.08);
    border-color: #d0d8e4;
}

.tech-card .tech-icon {
    width: 90px;
    height: 90px;
    margin: 0 auto 24px;
    transition: transform 0.4s ease;
}

.tech-card:hover .tech-icon {
    transform: scale(1.08);
}

.tech-card .tech-icon img {
    width: 100%;
    height: 100%;
    object-fit: contain;
}

.tech-card h3 {
    font-size: 17px;
    font-weight: 800;
    color: #12253f;
    margin-bottom: 14px;
    letter-spacing: 0.3px;
}

.tech-card p {
    color: #5a6a7e;
    font-size: 14px;
    line-height: 1.8;
    margin: 0;
}

.tech-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0;
    width: 100%; height: 0;
    background: linear-gradient(90deg, #162747, #1c3a5f);
    transition: height 0.35s ease;
}

.tech-card:hover::before {
    height: 4px;
}


/* ─────────────────────────────────────────────────────
   6. SCROLL REVEAL
   ───────────────────────────────────────────────────── */
.reveal-on-scroll {
    opacity: 0;
    transform: translateY(25px);
    transition: opacity 0.7s ease, transform 0.7s ease;
}

.reveal-on-scroll.revealed {
    opacity: 1;
    transform: translateY(0);
}


/* ─────────────────────────────────────────────────────
   7. RESPONSIVE BREAKPOINTS
   ───────────────────────────────────────────────────── */
@media (max-width: 992px) {
    .tl-slide { flex: 0 0 calc(100% / 2); }
    .tl-slider-wrapper { padding: 0 60px; }
    .tl-slider-wrapper .tl-arrow { width: 44px; height: 44px; font-size: 16px; }
    .tl-slider-wrapper .tl-arrow.tl-prev { left: 5px; }
    .tl-slider-wrapper .tl-arrow.tl-next { right: 5px; }
    .tl-slider-line { left: 60px; right: 60px; }
    .overview-grid { grid-template-columns: 1fr; gap: 24px; }
    .tech-grid { grid-template-columns: 1fr; gap: 20px; }
    .about-tabs-nav .nav-tabs .nav-link { padding: 16px 18px; font-size: 11px; letter-spacing: 0.8px; }
    .overview-card { padding: 35px 30px; }
    .overview-who .who-card { padding: 35px 30px; }
}

@media (max-width: 576px) {
    .tl-slide { flex: 0 0 100%; }
    .tl-slider-wrapper { padding: 0 50px; }
    .tl-slider-wrapper .tl-arrow { width: 38px; height: 38px; font-size: 14px; }
    .tl-slider-wrapper .tl-arrow.tl-prev { left: 3px; }
    .tl-slider-wrapper .tl-arrow.tl-next { right: 3px; }
    .tl-slider-line { display: none; }
    .tl-slide-inner .tl-year { width: 62px; height: 62px; font-size: 14px; }
    .tl-card-img { height: 160px; }
    .about-tabs-nav .nav-tabs .nav-link { padding: 14px 12px; font-size: 10px; letter-spacing: 0.5px; }
    .about-tabs-nav .nav-tabs .nav-link i { display: none; }
    .overview-card { padding: 30px 24px; }
    .overview-card h3 { font-size: 22px; }
    .tech-card { padding: 30px 24px; }
    .timeline-section { padding: 50px 0 50px; }
}

/* ─────────────────────────────────────────────────────
   8. IMAGE MODAL (LIGHTBOX) STYLES
   ───────────────────────────────────────────────────── */
.custom-modal {
    visibility: hidden;
    opacity: 0;
    position: fixed;
    z-index: 9999;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(10, 18, 35, 0.9); /* Dark background matching theme */
    backdrop-filter: blur(5px);
    display: flex;
    align-items: center;
    justify-content: center;
    transition: opacity 0.3s ease, visibility 0.3s ease;
}

.custom-modal.show {
    visibility: visible;
    opacity: 1;
}

.custom-modal-content {
    max-width: 90%;
    max-height: 90vh;
    border-radius: 8px;
    box-shadow: 0 10px 40px rgba(0,0,0,0.5);
    transform: scale(0.95);
    transition: transform 0.3s ease;
}

.custom-modal.show .custom-modal-content {
    transform: scale(1);
}

.custom-modal-close {
    position: absolute;
    top: 25px;
    right: 40px;
    color: #fff;
    font-size: 45px;
    font-weight: 300;
    transition: 0.3s;
    cursor: pointer;
    z-index: 10000;
}

.custom-modal-close:hover {
    color: #d8dde5;
    transform: scale(1.1);
}
</style>


<section class="abt-frame1">
    <div class="frm-cntnr">
        <div class="abt-frame1__img-hldr" style="background-image: url('assets/cover-photo-no-text.png');">
            <div class="abt-frame1__img p-5"></div>
        </div>
        <div class="abt-frame1__content">
            <div class="vertical-parent">
                <div class="vertical-align">
                    <div class="abt-frame1__content-wrapper">
                        <div class="abt-frame1__header">
                            <h2 class="clr--white">Who We Are</h2>
                        </div>
                        <div class="abt-frame1__desc scroll-custom">
                            <p class="clr--white"><?= $aboutrow['whoweare'] ?></p>
                        </div>
                        <div class="abt-btn vid">
                            <a class="clr--white" href="assets/The-Sentinel-Company-Profile_2024_00.pdf" target="_blank">
                                <i class="fas fa-download" style="margin-right: 8px;"></i>DOWNLOAD COMPANY PROFILE
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<div class="about-tabs-nav">
    <ul class="nav nav-tabs" id="aboutTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="overview-tab" data-bs-toggle="tab" data-bs-target="#overview-panel" type="button" role="tab" aria-selected="true">
                <i class="fas fa-bullseye"></i>Overview
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="timeline-tab" data-bs-toggle="tab" data-bs-target="#timeline-panel" type="button" role="tab" aria-selected="false">
                <i class="fas fa-clock"></i>Our Journey
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="techstructure-tab" data-bs-toggle="tab" data-bs-target="#techstructure-panel" type="button" role="tab" aria-selected="false">
                <i class="fas fa-cogs"></i>Technical Structure
            </button>
        </li>
    </ul>
</div>


<div class="tab-content about-tab-content" id="aboutTabsContent">

    <div class="tab-pane fade show active" id="overview-panel" role="tabpanel">
        <div class="overview-section">
            <div class="overview-grid">
                <div class="overview-card reveal-on-scroll">
                    <div class="ov-icon"><i class="fas fa-crosshairs"></i></div>
                    <div class="ov-label">Our Mission</div>
                    <h3>Driving Excellence in Solutions</h3>
                    <p><?= $aboutrow['mission'] ?></p>
                </div>
                <div class="overview-card reveal-on-scroll">
                    <div class="ov-icon"><i class="fas fa-eye"></i></div>
                    <div class="ov-label">Our Vision</div>
                    <h3>Leading the Industry Forward</h3>
                    <p><?= $aboutrow['vision'] ?></p>
                </div>
            </div>
            <div class="overview-who">
                <div class="who-card reveal-on-scroll">
                    <h3>About The Sentinel</h3>
                    <p><?= $aboutrow['whoweare'] ?></p>
                    <div class="who-cta">
                        <a href="assets/The-Sentinel-Company-Profile_2024_00.pdf" target="_blank">
                            <i class="fas fa-file-pdf" style="margin-right: 6px;"></i>View Full Profile
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="timeline-panel" role="tabpanel">
        <div class="timeline-section">
            <div class="section-header">
                <h2>Our Journey</h2>
                <p>Milestones that shaped The Sentinel over the years</p>
            </div>

            <div class="tl-slider-wrapper" id="tlSlider">
                <button class="tl-arrow tl-prev" id="tlPrev" aria-label="Previous" disabled>
                    <i class="fas fa-chevron-left"></i>
                </button>

                <div class="tl-slider-line"></div>

                <div class="tl-slider-viewport" id="tlViewport">
                    <div class="tl-slider-rail" id="tlRail">
                        <?php foreach ($timelineData as $idx => $tl) { ?>
                            <div class="tl-slide" data-index="<?= $idx ?>">
                                <div class="tl-slide-inner">
                                    <div class="tl-year"><?= $tl['year'] ?></div>
                                    <div class="tl-connector"></div>
                                    <div class="tl-card">
                                        <?php if (!empty($tl['image'])) { ?>
                                            <div class="tl-card-img" style="background-image: url('<?= $tl['image'] ?>');" data-img-url="<?= $tl['image'] ?>"></div>
                                        <?php } ?>
                                        <div class="tl-card-body">
                                            <p><?= $tl['details'] ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <button class="tl-arrow tl-next" id="tlNext" aria-label="Next">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>

            <div class="tl-dots" id="tlDots"></div>

            <div class="tl-counter">
                <span class="tl-counter-current" id="tlCurrent">1</span>
                <span> / </span>
                <span id="tlTotal"><?= $totalTimeline ?></span>
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="techstructure-panel" role="tabpanel">
        <div class="techstructure-section">
            <div class="section-header">
                <h2>Technical Structure</h2>
                <p>Our core capabilities that power every project</p>
            </div>
            <div class="tech-grid">
                <div class="tech-card reveal-on-scroll">
                    <div class="tech-icon">
                        <img src="./assets/SVG/SOFT.%20DEVELOPMENT.svg" alt="Software Development">
                    </div>
                    <h3>SOFTWARE DEVELOPMENT</h3>
                    <p>We turn ideas into reality. Our skilled engineers craft software solutions using the latest technologies. Our expertise spans the entire development lifecycle, from meticulously designing architecture to testing and deployment. This ensures our software is up to standard.</p>
                </div>
                <div class="tech-card reveal-on-scroll">
                    <div class="tech-icon">
                        <img src="./assets/SVG/PROJECT%20MANAGEMENT.svg" alt="Project Management">
                    </div>
                    <h3>PROJECT MANAGEMENT</h3>
                    <p>We orchestrate success! Our project management team thrives on keeping complex projects on track. We leverage industry-leading methodologies and cutting-edge tools to meticulously plan, execute, and monitor progress. We ensure a successful project delivery.</p>
                </div>
                <div class="tech-card reveal-on-scroll">
                    <div class="tech-icon">
                        <img src="./assets/SVG/ENGINEERING-DESIGN.svg" alt="Engineering & Design">
                    </div>
                    <h3>ENGINEERING & DESIGN</h3>
                    <p>Unleash your vision's potential! Our engineering design team blends creativity with technical expertise to transform ideas into functional, high-performing solutions. We use a systematic approach, iterating through prototypes until we bridge the gap.</p>
                </div>
                <div class="tech-card reveal-on-scroll">
                    <div class="tech-icon">
                        <img src="./assets/SVG/POST-PROJECT.svg" alt="Post Project Services">
                    </div>
                    <h3>POST PROJECT SERVICES</h3>
                    <p>Our commitment extends beyond the finish line! We offer comprehensive post-project services to ensure your success in the long run. This includes user training and support, ongoing system maintenance and optimization, and readily available technical assistance.</p>
                </div>
            </div>
        </div>
    </div>

</div>

<div id="imageModal" class="custom-modal">
    <span class="custom-modal-close">&times;</span>
    <img class="custom-modal-content" id="fullImage">
</div>

</div>

<script type="text/javascript">
    var pageID = 'AboutPage',
    baseHref = 'localhost',
    themeDir = '/_resources/themes/main';

    /* ════════════════════════════════════════════════════
       TIMELINE SLIDER — Transform + Drag + Swipe
       ════════════════════════════════════════════════════ */
    (function() {
        var rail      = document.getElementById('tlRail');
        var viewport  = document.getElementById('tlViewport');
        var prevBtn   = document.getElementById('tlPrev');
        var nextBtn   = document.getElementById('tlNext');
        var dotsWrap  = document.getElementById('tlDots');
        var counterEl = document.getElementById('tlCurrent');

        if (!rail || !viewport || !prevBtn || !nextBtn) return;

        var slides      = rail.querySelectorAll('.tl-slide');
        var totalSlides = slides.length;
        var currentPage = 0;
        var perView     = 3;

        // ── Drag state ──
        var isDragging     = false;
        var dragStartX     = 0;
        var dragCurrentX   = 0;
        var dragOffsetX    = 0;
        var baseOffset     = 0;
        var dragThreshold  = 50;
        var hasDragged     = false;

        // ── Helpers ──
        function getPerView() {
            var w = window.innerWidth;
            if (w <= 576)  return 1;
            if (w <= 992)  return 2;
            return 3;
        }

        function getTotalPages() {
            return Math.max(1, Math.ceil(totalSlides / perView));
        }

        function getViewportWidth() {
            return viewport.offsetWidth;
        }

        function getSlideWidth() {
            return getViewportWidth() / perView;
        }

        function getPageOffsetPx(page) {
            var slideW = getSlideWidth();
            var offset = -(page * perView * slideW);
            var maxOffset = -((totalSlides - perView) * slideW);
            if (totalSlides <= perView) return 0;
            if (offset < maxOffset) offset = maxOffset;
            if (offset > 0) offset = 0;
            return offset;
        }

        // ── Build dots ──
        function buildDots() {
            dotsWrap.innerHTML = '';
            var pages = getTotalPages();
            for (var i = 0; i < pages; i++) {
                var dot = document.createElement('button');
                dot.className = 'tl-dot' + (i === currentPage ? ' active' : '');
                dot.setAttribute('aria-label', 'Page ' + (i + 1));
                dot.setAttribute('data-page', i);
                dot.addEventListener('click', function() {
                    goToPage(parseInt(this.getAttribute('data-page')));
                });
                dotsWrap.appendChild(dot);
            }
        }

        // ── Update controls ──
        function updateControls() {
            var pages = getTotalPages();
            prevBtn.disabled = (currentPage <= 0);
            nextBtn.disabled = (currentPage >= pages - 1);

            var dots = dotsWrap.querySelectorAll('.tl-dot');
            dots.forEach(function(d, i) {
                d.classList.toggle('active', i === currentPage);
            });

            var startCard = currentPage * perView + 1;
            var endCard   = Math.min(startCard + perView - 1, totalSlides);
            counterEl.textContent = startCard + '\u2013' + endCard;
        }

        // ── Set transform (with or without animation) ──
        function setTransform(px, animated) {
            if (animated) {
                rail.style.transition = 'transform 0.45s cubic-bezier(0.25, 0.8, 0.25, 1)';
            } else {
                rail.style.transition = 'none';
            }
            rail.style.transform = 'translateX(' + px + 'px)';
        }

        // ── Go to page ──
        function goToPage(page) {
            var pages = getTotalPages();
            if (page < 0) page = 0;
            if (page >= pages) page = pages - 1;
            currentPage = page;

            var offset = getPageOffsetPx(page);
            setTransform(offset, true);
            updateControls();
        }

        // ── Arrow clicks ──
        prevBtn.addEventListener('click', function() { goToPage(currentPage - 1); });
        nextBtn.addEventListener('click', function() { goToPage(currentPage + 1); });

        // ── Keyboard nav ──
        document.addEventListener('keydown', function(e) {
            var panel = document.getElementById('timeline-panel');
            if (!panel || !panel.classList.contains('active')) return;
            if (e.key === 'ArrowLeft')  goToPage(currentPage - 1);
            if (e.key === 'ArrowRight') goToPage(currentPage + 1);
        });


        /* ──────────────────────────────────────────────
           DRAG / SWIPE ENGINE
           ────────────────────────────────────────────── */

        function onDragStart(x) {
            isDragging = true;
            hasDragged = false;
            dragStartX = x;
            dragCurrentX = x;
            baseOffset = getPageOffsetPx(currentPage);

            // Kill any running transition so drag feels instant
            rail.style.transition = 'none';
            viewport.style.cursor = 'grabbing';
        }

        function onDragMove(x) {
            if (!isDragging) return;
            dragCurrentX = x;
            dragOffsetX = dragCurrentX - dragStartX;

            if (Math.abs(dragOffsetX) > 5) {
                hasDragged = true;
            }

            var newOffset = baseOffset + dragOffsetX;

            // Rubber-band at boundaries
            var maxOffset = getPageOffsetPx(getTotalPages() - 1);
            if (newOffset > 0) {
                newOffset = newOffset * 0.3;
            } else if (newOffset < maxOffset) {
                var overscroll = newOffset - maxOffset;
                newOffset = maxOffset + (overscroll * 0.3);
            }

            setTransform(newOffset, false);
        }

        function onDragEnd() {
            if (!isDragging) return;
            isDragging = false;
            viewport.style.cursor = 'grab';

            var diff = dragCurrentX - dragStartX;

            if (Math.abs(diff) > dragThreshold) {
                if (diff < 0) {
                    goToPage(currentPage + 1);
                } else {
                    goToPage(currentPage - 1);
                }
            } else {
                goToPage(currentPage);
            }

            dragOffsetX = 0;
        }


        // ══ MOUSE EVENTS (desktop click + drag) ══
        viewport.addEventListener('mousedown', function(e) {
            if (e.target.closest('a, button')) return;
            e.preventDefault();
            onDragStart(e.clientX);
        });

        document.addEventListener('mousemove', function(e) {
            if (!isDragging) return;
            e.preventDefault();
            onDragMove(e.clientX);
        });

        document.addEventListener('mouseup', function() {
            onDragEnd();
        });

        document.addEventListener('mouseleave', function() {
            onDragEnd();
        });


        // ══ TOUCH EVENTS (mobile swipe + drag) ══
        var touchStartY = 0;
        var isHorizontalSwipe = null;

        viewport.addEventListener('touchstart', function(e) {
            var touch = e.touches[0];
            touchStartY = touch.clientY;
            isHorizontalSwipe = null;
            onDragStart(touch.clientX);
        }, { passive: true });

        viewport.addEventListener('touchmove', function(e) {
            if (!isDragging) return;
            var touch = e.touches[0];

            // Determine direction on first significant move
            if (isHorizontalSwipe === null) {
                var diffX = Math.abs(touch.clientX - dragStartX);
                var diffY = Math.abs(touch.clientY - touchStartY);
                if (diffX > 8 || diffY > 8) {
                    isHorizontalSwipe = (diffX > diffY);
                }
            }

            // Vertical scroll — cancel drag, let page scroll normally
            if (isHorizontalSwipe === false) {
                isDragging = false;
                viewport.style.cursor = '';
                goToPage(currentPage);
                return;
            }

            // Horizontal — prevent page scroll, do slider drag
            if (isHorizontalSwipe === true) {
                e.preventDefault();
            }

            onDragMove(touch.clientX);
        }, { passive: false });

        viewport.addEventListener('touchend', function() {
            onDragEnd();
            isHorizontalSwipe = null;
        }, { passive: true });


        // ══ Prevent accidental link clicks during drag ══
        viewport.addEventListener('click', function(e) {
            if (hasDragged) {
                e.preventDefault();
                e.stopPropagation();
                hasDragged = false;
            }
        }, true);


        /* ──────────────────────────────────────────────
           RESIZE + TAB SWITCH
           ────────────────────────────────────────────── */
        var resizeTimer;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(function() {
                var newPerView = getPerView();
                if (newPerView !== perView) {
                    perView = newPerView;
                    if (currentPage >= getTotalPages()) {
                        currentPage = getTotalPages() - 1;
                    }
                    buildDots();
                    goToPage(currentPage);
                }
            }, 150);
        });

        var timelineTab = document.getElementById('timeline-tab');
        if (timelineTab) {
            timelineTab.addEventListener('shown.bs.tab', function() {
                perView = getPerView();
                buildDots();
                goToPage(currentPage);
            });
        }

        // ── Set default cursor ──
        viewport.style.cursor = 'grab';

        // ── Initialize ──
        perView = getPerView();
        buildDots();
        goToPage(0);
    })();


    /* ════════════════════════════════════════════════════
       SCROLL REVEAL
       ════════════════════════════════════════════════════ */
    (function() {
        var els = document.querySelectorAll('.reveal-on-scroll');
        if ('IntersectionObserver' in window) {
            var obs = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('revealed');
                        obs.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.15 });
            els.forEach(function(el) { obs.observe(el); });
        } else {
            els.forEach(function(el) { el.classList.add('revealed'); });
        }
    })();


    /* ════════════════════════════════════════════════════
       RE-TRIGGER REVEALS ON TAB SWITCH
       ════════════════════════════════════════════════════ */
    (function() {
        var tabs = document.querySelectorAll('#aboutTabs button[data-bs-toggle="tab"]');
        tabs.forEach(function(tab) {
            tab.addEventListener('shown.bs.tab', function() {
                var target = document.querySelector(tab.getAttribute('data-bs-target'));
                if (target) {
                    target.querySelectorAll('.reveal-on-scroll:not(.revealed)').forEach(function(el) {
                        el.classList.add('revealed');
                    });
                }
            });
        });
    })();

    /* ════════════════════════════════════════════════════
       IMAGE LIGHTBOX MODAL (NEW)
       ════════════════════════════════════════════════════ */
    (function() {
        var modal = document.getElementById("imageModal");
        var modalImg = document.getElementById("fullImage");
        var closeBtn = document.querySelector(".custom-modal-close");
        var images = document.querySelectorAll(".tl-card-img");

        // Open modal on image click
        images.forEach(function(img) {
            img.addEventListener("click", function() {
                var imageUrl = this.getAttribute("data-img-url");
                if(imageUrl) {
                    modalImg.src = imageUrl;
                    modal.classList.add("show");
                }
            });
        });

        // Function to close modal
        function closeModal() {
            modal.classList.remove("show");
            // Clear the src after the animation finishes
            setTimeout(function() {
                if(!modal.classList.contains("show")) modalImg.src = "";
            }, 300);
        }

        // Close when clicking the "X"
        if(closeBtn) {
            closeBtn.addEventListener("click", closeModal);
        }

        // Close when clicking anywhere on the dark background
        modal.addEventListener("click", function(e) {
            if (e.target === modal) {   
                closeModal();
            }
        });

        // Close when pressing the "Escape" key
        document.addEventListener('keydown', function(e) {
            if (e.key === "Escape" && modal.classList.contains("show")) {
                closeModal();
            }
        });
    })();
</script>

<?php include "template/footer.php"; ?>