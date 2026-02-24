<?php 
include "template/header-dark.php"; 

// FETCH DATA
$sql = "SELECT * FROM contact_details 
        ORDER BY 
        CASE 
            WHEN name LIKE '%Sales Office%' OR location LIKE '%Tamaraw%' THEN 0 
            ELSE 1 
        END, id ASC";
$result = $conn->query($sql);

$contacts = [];
while ($row = $result->fetch_assoc()) {
    $contacts[] = $row;
}
?>

<style>
    /* Reset & Base */
    body { background-color: #f9f9f9; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }

    /* Minimalist Page Title */
    .page-header {
        max-width: 1400px;
        margin: 30px auto 10px;
        padding-left: 20px;
    }
    .page-header h1 {
        font-size: 24px;
        font-weight: 600;
        color: #888;
        text-transform: uppercase;
        letter-spacing: 2px;
        margin: 0;
    }

    /* Main Dashboard Container */
    .contact-dashboard {
        display: flex;
        height: 80vh;
        max-width: 1400px;
        margin: 20px auto 60px;
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.05);
        overflow: hidden;
        border: 1px solid #eaeaea;
    }

    /* LEFT SIDEBAR (List) */
    .sidebar {
        width: 320px;
        background: #fff;
        border-right: 1px solid #f0f0f0;
        display: flex;
        flex-direction: column;
        flex-shrink: 0;
    }

    .sidebar-header {
        padding: 20px 25px;
        border-bottom: 1px solid #f0f0f0;
        background: #fcfcfc;
    }
    .sidebar-header h3 {
        font-size: 14px;
        font-weight: 700;
        color: #162747;
        margin: 0;
        text-transform: uppercase;
    }

    .sidebar-list {
        overflow-y: auto;
        flex: 1;
    }

    .nav-item {
        padding: 18px 25px;
        cursor: pointer;
        border-bottom: 1px solid #f9f9f9;
        transition: all 0.2s;
        border-left: 4px solid transparent;
    }

    .nav-item:hover { background: #f4f7f6; }

    .nav-item.active {
        background: #fff;
        border-left-color: #28a745;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }

    .nav-item h4 { margin: 0; font-size: 15px; font-weight: 600; color: #333; }
    .nav-item p { margin: 4px 0 0; font-size: 12px; color: #999; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

    /* RIGHT PANEL (Content) */
    .content-panel {
        flex: 1;
        padding: 0;
        position: relative;
        background: #fff;
        overflow-y: auto;
    }

    .active-content {
        padding: 40px 60px;
        animation: fadeIn 0.3s ease;
    }

    /* IMAGE WRAPPER */
    .img-wrapper {
        width: 100%;
        height: 350px;
        position: relative;
        margin-bottom: 30px;
        border-radius: 8px;
        background: #eee;
        cursor: pointer;
    }

    .img-wrapper img.main-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 8px;
    }

    /* HOVER POPUP */
    .img-popup-hover {
        position: absolute;
        top: -10%; left: -2%; width: 104%; height: 120%;
        background: #fff;
        padding: 8px;
        border-radius: 8px;
        box-shadow: 0 20px 50px rgba(0,0,0,0.3);
        z-index: 100;
        opacity: 0;
        visibility: hidden;
        transform: scale(0.95);
        transition: all 0.2s ease-out;
        pointer-events: none;
    }

    .img-popup-hover img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 4px;
    }

    .img-wrapper:hover .img-popup-hover {
        opacity: 1;
        visibility: visible;
        transform: scale(1);
    }

    .hover-hint {
        position: absolute;
        bottom: 15px; right: 15px;
        background: rgba(0,0,0,0.6);
        color: #fff;
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 11px;
        text-transform: uppercase;
        pointer-events: none;
    }

    /* LAYOUT & TYPOGRAPHY FIXES */
    .detail-title { margin-bottom: 30px; border-bottom: 1px solid #eee; padding-bottom: 15px; }
    .detail-title h1 { font-size: 32px; color: #162747; margin: 0; font-weight: 700; }
    
    .info-grid { 
        display: flex; 
        flex-wrap: wrap;
        gap: 60px;
    }
    
    .col-1, .col-2 {
        flex: 1;
        min-width: 300px;
    }

    .info-box { margin-bottom: 30px; }
    
    .label { 
        font-size: 11px; 
        text-transform: uppercase; 
        letter-spacing: 1px; 
        color: #999; 
        font-weight: 700; 
        display: block; 
        margin-bottom: 10px; 
    }
    
    .value { 
        font-size: 16px; 
        color: #333; 
        line-height: 1.6; 
        width: 100%;
    }

    .address-text {
        white-space: normal;
        max-width: 100%;
    }

    .phone-number {
        display: block;
        white-space: nowrap;
        margin-bottom: 5px;
        color: #333;
        text-decoration: none;
    }
    .phone-number:hover { color: #28a745; }

    /* Website link */
    .website-link {
        color: #162747;
        text-decoration: none;
        font-weight: 600;
    }
    .website-link:hover { color: #28a745; text-decoration: underline; }

    /* Button */
    .btn-map {
        display: inline-flex; align-items: center; gap: 10px;
        padding: 12px 30px; background: #162747; color: #fff;
        text-decoration: none; border-radius: 5px; font-weight: 600;
        font-size: 13px; text-transform: uppercase; letter-spacing: 1px;
        transition: 0.3s; margin-top: 20px;
    }
    .btn-map:hover { background: #0f1b33; color: #fff; box-shadow: 0 5px 15px rgba(22, 39, 71, 0.3); }

    /* Lightbox */
    .lightbox-overlay {
        position: fixed; top: 0; left: 0; width: 100%; height: 100%;
        background: rgba(0,0,0,0.9); z-index: 9999;
        display: none; justify-content: center; align-items: center;
    }
    .lightbox-overlay img { max-width: 90%; max-height: 90vh; border-radius: 4px; }

    @keyframes fadeIn { from { opacity: 0; transform: translateY(5px); } to { opacity: 1; transform: translateY(0); } }

    /* Mobile */
    @media (max-width: 900px) {
        .contact-dashboard { flex-direction: column; height: auto; }
        .sidebar { width: 100%; height: 300px; }
        .info-grid { flex-direction: column; gap: 30px; }
        .active-content { padding: 30px; }
    }
</style>

<div class="spacing"></div>

<div class="page-header">
    <h1>Contact Us</h1>
</div>

<div class="contact-dashboard">
    
    <!-- LEFT: List -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h3>Locations</h3>
        </div>
        <div class="sidebar-list">
            <?php foreach ($contacts as $index => $row): ?>
                <div class="nav-item <?php echo $index === 0 ? 'active' : ''; ?>" 
                     onclick="loadContact(<?php echo $index; ?>)">
                    <h4><?php echo htmlspecialchars($row['name']); ?></h4>
                    <p><?php echo htmlspecialchars($row['location']); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- RIGHT: Details -->
    <div class="content-panel" id="contentArea"></div>

</div>

<!-- Lightbox for Click -->
<div class="lightbox-overlay" id="lightbox" onclick="this.style.display='none'">
    <img id="lightboxImg" src="">
</div>

<!-- ======================================================= -->
<!-- NEWSLETTER SECTION (Restored)                           -->
<!-- ======================================================= -->
<section class="cnt-frame2">
    <div class="frm-cntnr">
        <div class="newsletter-card">
            <div class="news-wrapper">
                <div class="newsletter-title">
                    <h3>Subscribe to our Newsletter</h3>
                </div>
                <div class="newsletter-desc">
                    <p>Stay up to date with us for the latest news, events, products updates straight to your email inbox.</p>
                </div>
                <form id="newsletterForm" method="post">
                    <div class="newsletter-input-hldr">
                        <div class="newsletter-input">
                            <input type="email" name="email" placeholder="Enter valid email address" required="">
                        </div>
                        
                        <!-- ReCaptcha -->
                        <div class="recaptcha-hldr mobile animate-up">
                            <div class="g-recaptcha" data-sitekey="6LdzqH0iAAAAAH4aACDM-FCozJysYsP5mzuAxxNQ"></div>
                        </div>
                        <div class="recaptcha-hldr animate-up desktop">
                            <div class="g-recaptcha" data-sitekey="6LdzqH0iAAAAAH4aACDM-FCozJysYsP5mzuAxxNQ"></div>
                        </div>

                        <input type="hidden" name="postFlag" value="1">
                        <div class="newsletter-btn btn" id="newsletterBtn">
                            <a href="index.htm#">SUBSCRIBE</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="leaf-hldr">
            <!-- Optional leaf images from original template -->
        </div>
    </div>
</section>

<!-- Javascript Logic -->
<script>
    var contacts = <?php echo json_encode($contacts); ?>;

    /* =========================================================
       SALES OFFICE (TAMARAW) — Master Data
       All contact info for the main office in one place.
       Update here if anything changes.
       ========================================================= */
    var salesOffice = {
        address:   '#25 Upper Tamaraw Hills Road, Marulas, Valenzuela City 1440',
        telephone: '(02) 8726-0529',
        mobile: [
            '+63 917 134 3755',
            '+63 917 100 9436',
            '+63 917 100 4712'
        ],
        email:    'sales@thesentinelautomation.com',
        website:  'www.thesentinelautomation.com',
        image:    'assets/siteimgs/TamarawOffice.jpg',
        mapLink:  'https://www.google.com/maps/place/The+Sentinel+Automation+and+Security+Solutions+Inc./@14.6791716,120.9797571,17z/data=!3m1!4b1!4m6!3m5!1s0x3397b5bafcec6b99:0x5b63af3ca9b98ae8!8m2!3d14.6791664!4d120.982332!16s%2Fg%2F11w1d5xw80?entry=ttu&g_ep=EgoyMDI2MDIxMS4wIKXMDSoASAFQAw%3D%3D'
    };

    function loadContact(index) {
        document.querySelectorAll('.nav-item').forEach(function(el) { el.classList.remove('active'); });
        document.querySelectorAll('.nav-item')[index].classList.add('active');

        var data = contacts[index];
        var isTamaraw = (data.name.toLowerCase().includes('sales office') || data.location.toLowerCase().includes('tamaraw'));

        var imgSrc  = isTamaraw ? salesOffice.image : 'assets/ContactUsPage/office/img.png';
        var mapLink = isTamaraw ? salesOffice.mapLink : 'https://maps.google.com/?q=' + encodeURIComponent(data.location);

        /* ── Contact Numbers ── */
        var phoneHtml = '';
        if (isTamaraw) {
            var mobileLinks = '';
            for (var i = 0; i < salesOffice.mobile.length; i++) {
                var num = salesOffice.mobile[i];
                var rawNum = num.replace(/\s/g, '');
                mobileLinks += '<a href="tel:' + rawNum + '" class="phone-number">' + num + '</a>';
            }
            phoneHtml = 
                '<div class="value">' +
                    '<div style="margin-bottom:15px;">' +
                        '<strong>Telephone:</strong><br>' +
                        '<a href="tel:0287260529" class="phone-number">' + salesOffice.telephone + '</a>' +
                    '</div>' +
                    '<div>' +
                        '<strong>Mobile:</strong><br>' +
                        mobileLinks +
                    '</div>' +
                '</div>';
        } else {
            phoneHtml = '<div class="value"><a href="tel:' + data.contact + '" class="phone-number">' + data.contact + '</a></div>';
        }

        /* ── Email ── */
        var emailAddr = isTamaraw ? salesOffice.email : data.email;

        /* ── Address ── */
        var addressText = isTamaraw ? salesOffice.address : data.location;

        /* ── Website row (only for Sales Office) ── */
        var websiteHtml = '';
        if (isTamaraw) {
            websiteHtml = 
                '<div class="info-box">' +
                    '<span class="label">Website</span>' +
                    '<div class="value">' +
                        '<a href="https://' + salesOffice.website + '" target="_blank" class="website-link">' + salesOffice.website + '</a>' +
                    '</div>' +
                '</div>';
        }

        /* ── Build Full HTML ── */
        var html = 
            '<div class="active-content">' +
                '<div class="img-wrapper" onclick="openLightbox(\'' + imgSrc + '\')">' +
                    '<img class="main-img" src="' + imgSrc + '" onerror="this.src=\'assets/ContactUsPage/office/img.png\'">' +
                    '<span class="hover-hint">Hover to Zoom / Click to View</span>' +
                    '<div class="img-popup-hover">' +
                        '<img src="' + imgSrc + '" onerror="this.src=\'assets/ContactUsPage/office/img.png\'">' +
                    '</div>' +
                '</div>' +

                '<div class="detail-title">' +
                    '<h1>' + data.name + '</h1>' +
                '</div>' +

                '<div class="info-grid">' +
                    '<div class="col-1">' +
                        '<div class="info-box">' +
                            '<span class="label">Office Address</span>' +
                            '<div class="value address-text">' + addressText + '</div>' +
                        '</div>' +
                        '<div class="info-box">' +
                            '<span class="label">Email</span>' +
                            '<div class="value"><a href="mailto:' + emailAddr + '" class="phone-number">' + emailAddr + '</a></div>' +
                        '</div>' +
                        websiteHtml +
                    '</div>' +
                    '<div class="col-2">' +
                        '<div class="info-box">' +
                            '<span class="label">Contact Numbers</span>' +
                            phoneHtml +
                        '</div>' +
                        '<div class="info-box">' +
                            '<span class="label">Social Media</span>' +
                            '<div class="value" style="display:flex; gap:15px; font-size:20px;">' +
                                (data.fblink ? '<a href="' + data.fblink + '" target="_blank"><i class="fab fa-facebook-f"></i></a>' : '') +
                                '<a href="#" target="_blank"><i class="fab fa-youtube"></i></a>' +
                            '</div>' +
                        '</div>' +
                    '</div>' +
                '</div>' +

                '<a href="' + mapLink + '" target="_blank" class="btn-map">' +
                    'View on Google Maps <i class="fas fa-arrow-right"></i>' +
                '</a>' +
            '</div>';

        document.getElementById('contentArea').innerHTML = html;
    }

    function openLightbox(src) {
        document.getElementById('lightboxImg').src = src;
        document.getElementById('lightbox').style.display = 'flex';
    }

    document.addEventListener("DOMContentLoaded", function() {
        if(contacts.length > 0) loadContact(0);

        // Burger Fix
        var menuBtns = document.querySelectorAll('.menu-btn, .navbar-toggler');
        var menuContainer = document.querySelector('.menu-hldr');
        var closeBtn = document.querySelector('.menu-close');

        if(menuContainer) {
            var openMenu = function(e) { e.preventDefault(); menuContainer.style.display = 'block'; menuContainer.style.opacity = '1'; menuContainer.style.visibility = 'visible'; if(typeof $ !== 'undefined') $('.menu-hldr').fadeIn(); };
            var closeMenu = function() { if(typeof $ !== 'undefined') { $('.menu-hldr').fadeOut(); } else { menuContainer.style.display = 'none'; } };
            menuBtns.forEach(function(btn) { btn.addEventListener('click', openMenu); });
            if(closeBtn) closeBtn.addEventListener('click', closeMenu);
        }
    });
</script>

<?php include "template/footer.php"; ?>