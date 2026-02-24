<?php include "template/header-dark.php"; ?>

<style>
    /* Shelf Layout Styles */
    .certificates-section { padding: 80px 0; background-color: #f9f9f9; }
    
    .cert-shelf {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 40px;
        margin-top: 50px;
    }

    .cert-card {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        overflow: hidden;
        position: relative;
        text-align: center;
        border-bottom: 4px solid #12253f;
        cursor: pointer;
    }

    .cert-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.15);
    }

    .cert-thumb {
        height: 250px;
        width: 100%;
        object-fit: contain;
        background-color: #eef2f5;
        padding: 20px;
    }

    .cert-title {
        padding: 20px 15px;
        font-weight: 700;
        color: #12253f;
        text-transform: uppercase;
        font-size: 0.9rem;
        min-height: 80px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Page badge on cards with multiple pages */
    .cert-badge {
        position: absolute;
        top: 12px;
        right: 12px;
        background: #12253f;
        color: #fff;
        font-size: 11px;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 12px;
        letter-spacing: 0.3px;
        pointer-events: none;
    }

    /* ============================================
       ZOOM MODAL STYLES
       ============================================ */
    .zoom-modal {
        display: none;
        position: fixed;
        z-index: 10000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.92);
        overflow: hidden;
        touch-action: none;
        -webkit-user-select: none;
        user-select: none;
    }

    .modal-content-wrapper {
        width: 100%;
        height: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
        overflow: hidden;
        touch-action: none;
    }

    .modal-image {
        max-width: 90%;
        max-height: 80%;
        cursor: grab;
        transform-origin: 0 0;
        will-change: transform;
        -webkit-user-drag: none;
        user-select: none;
        -webkit-touch-callout: none;
    }

    .modal-image.is-panning {
        cursor: grabbing;
    }

    .close-modal {
        position: absolute;
        top: 15px;
        right: 20px;
        color: #fff;
        font-size: 36px;
        font-weight: bold;
        cursor: pointer;
        z-index: 10001;
        width: 44px;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: rgba(255,255,255,0.1);
        transition: background 0.2s;
        line-height: 1;
    }

    .close-modal:hover,
    .close-modal:active {
        background: rgba(255,255,255,0.25);
    }

    /* --- Page Navigation Arrows --- */
    .page-nav {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        color: #fff;
        font-size: 40px;
        font-weight: bold;
        cursor: pointer;
        z-index: 10001;
        width: 50px;
        height: 50px;
        display: none;          /* Hidden by default, shown when multi-page */
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: rgba(255,255,255,0.12);
        transition: background 0.2s;
        -webkit-tap-highlight-color: transparent;
    }

    .page-nav:hover,
    .page-nav:active {
        background: rgba(255,255,255,0.3);
    }

    .page-nav.prev { left: 16px; }
    .page-nav.next { right: 16px; }

    .page-nav.visible { display: flex; }

    /* --- Page Indicator (e.g., "Page 1 / 3") --- */
    .page-indicator {
        position: absolute;
        top: 20px;
        left: 50%;
        transform: translateX(-50%);
        color: #fff;
        font-size: 14px;
        font-weight: 600;
        background: rgba(0,0,0,0.5);
        backdrop-filter: blur(6px);
        -webkit-backdrop-filter: blur(6px);
        padding: 6px 18px;
        border-radius: 20px;
        z-index: 10001;
        display: none;          /* Hidden for single-page docs */
        letter-spacing: 0.5px;
    }

    .page-indicator.visible { display: block; }

    /* --- Zoom Controls Bar --- */
    .zoom-controls {
        position: absolute;
        bottom: 70px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        align-items: center;
        gap: 6px;
        background: rgba(0,0,0,0.6);
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        border-radius: 30px;
        padding: 6px 14px;
        z-index: 10001;
    }

    .zoom-btn {
        background: rgba(255,255,255,0.15);
        color: #fff;
        border: none;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        font-size: 20px;
        font-weight: bold;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.2s;
        -webkit-tap-highlight-color: transparent;
    }

    .zoom-btn:hover,
    .zoom-btn:active {
        background: rgba(255,255,255,0.3);
    }

    .zoom-level {
        color: #fff;
        font-size: 13px;
        font-weight: 600;
        min-width: 50px;
        text-align: center;
        letter-spacing: 0.5px;
    }

    .zoom-reset-btn {
        background: rgba(255,255,255,0.15);
        color: #fff;
        border: none;
        border-radius: 16px;
        padding: 6px 14px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        -webkit-tap-highlight-color: transparent;
    }

    .zoom-reset-btn:hover,
    .zoom-reset-btn:active {
        background: rgba(255,255,255,0.3);
    }

    /* --- Instruction Toast --- */
    .zoom-instruction {
        position: absolute;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        color: #fff;
        font-size: 13px;
        pointer-events: none;
        background: rgba(0,0,0,0.55);
        backdrop-filter: blur(6px);
        -webkit-backdrop-filter: blur(6px);
        padding: 8px 20px;
        border-radius: 20px;
        white-space: nowrap;
        transition: opacity 0.5s ease;
        z-index: 10001;
    }

    .zoom-instruction.fade-out {
        opacity: 0;
    }

    /* Download Section */
    .download-section {
        background: #12253f;
        color: white;
        padding: 60px 0;
        text-align: center;
        margin-top: 80px;
    }
    .download-btn {
        display: inline-block;
        border: 2px solid #fff;
        padding: 15px 40px;
        color: #fff;
        font-weight: bold;
        text-transform: uppercase;
        margin-top: 20px;
        transition: all 0.3s;
        text-decoration: none;
    }
    .download-btn:hover { background: #fff; color: #12253f; }

    /* Mobile adjustments */
    @media (max-width: 768px) {
        .zoom-controls {
            bottom: 60px;
            padding: 5px 10px;
            gap: 4px;
        }
        .zoom-btn {
            width: 36px;
            height: 36px;
            font-size: 18px;
        }
        .zoom-level { font-size: 12px; min-width: 44px; }
        .zoom-instruction { font-size: 12px; bottom: 16px; }
        .modal-image { max-width: 95%; max-height: 75%; }
        .page-nav {
            width: 42px;
            height: 42px;
            font-size: 30px;
        }
        .page-nav.prev { left: 8px; }
        .page-nav.next { right: 8px; }
        .page-indicator { font-size: 12px; padding: 5px 14px; }
    }
</style>

<div class="spacing"></div>

<section class="certificates-section">
    <div class="frm-cntnr width--85">
        <div class="pdct-frame1__title text-center">
            <h1 class="clr--green">Permits & Licenses</h1>
            <p style="max-width: 700px; margin: 20px auto; color: #666;">
                Click any document below to inspect it in high resolution.
            </p>
        </div>

        <div class="cert-shelf">

            <!-- PCAB License (1 page) -->
            <div class="cert-card" onclick="openZoomModal('pcab')">
                <img src="assets/PERMITS, LICENSES & CERTIFICATES/PCAB License.jpg" class="cert-thumb" alt="PCAB License">
                <div class="cert-title">PCAB License</div>
            </div>

            <!-- PHILGEPS (1 page) -->
            <div class="cert-card" onclick="openZoomModal('philgeps')">
                <img src="assets/PERMITS, LICENSES & CERTIFICATES/PHILGEPS.jpg" class="cert-thumb" alt="PHILGEPS">
                <div class="cert-title">PHILGEPS Registration</div>
            </div>

            <!-- SEC Registration (2 pages) -->
            <div class="cert-card" onclick="openZoomModal('sec')">
                <span class="cert-badge">2 Pages</span>
                <img src="assets/PERMITS, LICENSES & CERTIFICATES/SEC REGISTRATION page 1.jpg" class="cert-thumb" alt="SEC Registration">
                <div class="cert-title">SEC Registration</div>
            </div>

            <!-- Business Permit (1 page) -->
            <div class="cert-card" onclick="openZoomModal('business')">
                <img src="assets/PERMITS, LICENSES & CERTIFICATES/BUSINESS PERMIT.jpg" class="cert-thumb" alt="Business Permit">
                <div class="cert-title">Business Permit</div>
            </div>

            <!-- BIR Certificate of Registration (3 pages) -->
            <div class="cert-card" onclick="openZoomModal('bir')">
                <span class="cert-badge">3 Pages</span>
                <img src="assets/PERMITS, LICENSES & CERTIFICATES/CERTIFICATE OF REGISTRATION page 1.jpg" class="cert-thumb" alt="BIR Registration">
                <div class="cert-title">BIR Certificate of Registration</div>
            </div>

            <!-- Certificate of Accreditation (2 pages) -->
            <div class="cert-card" onclick="openZoomModal('accreditation')">
                <span class="cert-badge">2 Pages</span>
                <img src="assets/PERMITS, LICENSES & CERTIFICATES/CERTIFICATE OF ACCREDITATION page 1.jpg" class="cert-thumb" alt="Accreditation">
                <div class="cert-title">Certificate of Accreditation</div>
            </div>

            <!-- Dealer's Permit (1 page) -->
            <div class="cert-card" onclick="openZoomModal('dealer')">
                <img src="assets/PERMITS, LICENSES & CERTIFICATES/DEALER_S PERMIT.jpg" class="cert-thumb" alt="Dealer's Permit">
                <div class="cert-title">Dealer's Permit</div>
            </div>

            <!-- Permit to Import (1 page) -->
            <div class="cert-card" onclick="openZoomModal('import')">
                <img src="assets/PERMITS, LICENSES & CERTIFICATES/PERMIT TO IMPORT.jpg" class="cert-thumb" alt="Permit to Import">
                <div class="cert-title">Permit to Import</div>
            </div>

        </div>
    </div>
</section>

<!-- ZOOM MODAL STRUCTURE -->
<div id="myZoomModal" class="zoom-modal">
    <span class="close-modal" onclick="closeZoomModal()" title="Close">&times;</span>

    <!-- Page Navigation Arrows -->
    <span class="page-nav prev" id="pagePrev" onclick="changePage(-1)" title="Previous Page">&#8249;</span>
    <span class="page-nav next" id="pageNext" onclick="changePage(1)" title="Next Page">&#8250;</span>

    <!-- Page Indicator -->
    <div class="page-indicator" id="pageIndicator"></div>

    <div class="modal-content-wrapper" id="modalWrapper">
        <img class="modal-image" id="img01" alt="Document Preview">
    </div>

    <!-- Zoom Control Buttons -->
    <div class="zoom-controls">
        <button class="zoom-btn" onclick="zoomBy(-1)" title="Zoom Out">&minus;</button>
        <span class="zoom-level" id="zoomLevel">100%</span>
        <button class="zoom-btn" onclick="zoomBy(1)" title="Zoom In">&plus;</button>
        <button class="zoom-reset-btn" onclick="resetZoom()" title="Reset View">Reset</button>
    </div>
    <div class="zoom-instruction" id="zoomHint"></div>
</div>

<section class="download-section">
    <div class="frm-cntnr width--85">
        <h2>Corporate Profile</h2>
        <p>Download our complete company profile to learn more about our capabilities and history.</p>
        <a href="assets/PERMITS%2C%20LICENSES%20%26%20CERTIFICATES/2026-TSAASICompanyProfile.PDF" class="download-btn" download>Download Profile (PDF)</a>
    </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
/* =============================================================
   UNIVERSAL ZOOM VIEWER — Multi-Page + Desktop + Mobile + Tablet
   ============================================================= */
(function () {
    'use strict';

    var BASE = 'assets/PERMITS, LICENSES & CERTIFICATES/';

    /* ─────────────────────────────────────────────
       DOCUMENT REGISTRY — All credentials & pages
       ───────────────────────────────────────────── */
    var documents = {
        pcab: [
            BASE + 'PCAB License.jpg'
        ],
        philgeps: [
            BASE + 'PHILGEPS.jpg'
        ],
        sec: [
            BASE + 'SEC REGISTRATION page 1.jpg',
            BASE + 'SEC REGISTRATION page 2.jpg'
        ],
        business: [
            BASE + 'BUSINESS PERMIT.jpg'
        ],
        bir: [
            BASE + 'CERTIFICATE OF REGISTRATION page 1.jpg',
            BASE + 'CERTIFICATE OF REGISTRATION page 2.jpg',
            BASE + 'CERTIFICATE OF REGISTRATION page 3.jpg'
        ],
        accreditation: [
            BASE + 'CERTIFICATE OF ACCREDITATION page 1.jpg',
            BASE + 'CERTIFICATE OF ACCREDITATION page 2.jpg'
        ],
        dealer: [
            BASE + 'DEALER_S PERMIT.jpg'
        ],
        import: [
            BASE + 'PERMIT TO IMPORT.jpg'
        ]
    };

    // ── DOM References ──
    var modal       = document.getElementById('myZoomModal');
    var wrapper     = document.getElementById('modalWrapper');
    var img         = document.getElementById('img01');
    var hint        = document.getElementById('zoomHint');
    var levelEl     = document.getElementById('zoomLevel');
    var pageIndEl   = document.getElementById('pageIndicator');
    var prevBtn     = document.getElementById('pagePrev');
    var nextBtn     = document.getElementById('pageNext');

    // ── Configuration ──
    var MIN_SCALE     = 1;
    var MAX_SCALE     = 6;
    var ZOOM_STEP     = 0.35;
    var DBL_TAP_SCALE = 2.5;
    var DBL_TAP_DELAY = 300;
    var HINT_DURATION = 3000;

    // ── Zoom & Pan State ──
    var scale  = 1;
    var pointX = 0;
    var pointY = 0;

    var isPanning = false;
    var panStartX = 0;
    var panStartY = 0;

    var lastTouchEnd     = 0;
    var initialPinchDist = null;
    var initialPinchScale = 1;
    var touchPanning     = false;

    var hintTimer = null;

    // ── Page State ──
    var currentPages = [];      // Array of image URLs for current document
    var currentPageIndex = 0;   // Which page we're on (0-based)

    // ── Helpers ──
    function isTouchDevice() { return 'ontouchstart' in window || navigator.maxTouchPoints > 0; }
    function clamp(val, min, max) { return Math.min(Math.max(val, min), max); }

    function updateTransform() {
        img.style.transform = 'translate(' + pointX + 'px,' + pointY + 'px) scale(' + scale + ')';
        levelEl.textContent = Math.round(scale * 100) + '%';
    }

    function constrainPan() {
        var rect = wrapper.getBoundingClientRect();
        var limitX = Math.max(0, (img.offsetWidth  * scale - rect.width)  / 2 + rect.width  * 0.3);
        var limitY = Math.max(0, (img.offsetHeight * scale - rect.height) / 2 + rect.height * 0.3);
        pointX = clamp(pointX, -limitX, limitX);
        pointY = clamp(pointY, -limitY, limitY);
    }

    function applyZoom(newScale, cx, cy) {
        var prev = scale;
        scale = clamp(newScale, MIN_SCALE, MAX_SCALE);

        if (cx !== undefined && cy !== undefined) {
            var xs = (cx - pointX) / prev;
            var ys = (cy - pointY) / prev;
            pointX = cx - xs * scale;
            pointY = cy - ys * scale;
        }

        if (scale <= MIN_SCALE) {
            scale  = MIN_SCALE;
            pointX = 0;
            pointY = 0;
        } else {
            constrainPan();
        }
        updateTransform();
    }

    /* ─────────────────────────────────────────────
       PAGE NAVIGATION
       ───────────────────────────────────────────── */
    function updatePageUI() {
        var total = currentPages.length;
        var isMulti = total > 1;

        // Show/hide page indicator
        if (isMulti) {
            pageIndEl.textContent = 'Page ' + (currentPageIndex + 1) + ' / ' + total;
            pageIndEl.classList.add('visible');
        } else {
            pageIndEl.classList.remove('visible');
        }

        // Show/hide prev/next arrows
        if (isMulti && currentPageIndex > 0) {
            prevBtn.classList.add('visible');
        } else {
            prevBtn.classList.remove('visible');
        }

        if (isMulti && currentPageIndex < total - 1) {
            nextBtn.classList.add('visible');
        } else {
            nextBtn.classList.remove('visible');
        }
    }

    function loadPage(index) {
        currentPageIndex = index;
        img.src = currentPages[currentPageIndex];
        resetZoom();
        updatePageUI();
    }

    window.changePage = function (direction) {
        var newIndex = currentPageIndex + direction;
        if (newIndex >= 0 && newIndex < currentPages.length) {
            loadPage(newIndex);
        }
    };

    /* ─────────────────────────────────────────────
       PUBLIC — Open / Close / Reset / ZoomBy
       ───────────────────────────────────────────── */
    window.resetZoom = function () {
        scale  = 1;
        pointX = 0;
        pointY = 0;
        updateTransform();
    };

    window.openZoomModal = function (docKey) {
        var pages = documents[docKey];
        if (!pages || pages.length === 0) return;

        currentPages = pages;
        modal.style.display = 'block';
        document.body.style.overflow = 'hidden';

        loadPage(0);    // Always start on page 1
        showHint();
    };

    window.closeZoomModal = function () {
        modal.style.display = 'none';
        document.body.style.overflow = 'auto';
        if (hintTimer) clearTimeout(hintTimer);
    };

    window.zoomBy = function (direction) {
        var rect = wrapper.getBoundingClientRect();
        var cx = rect.left + rect.width / 2;
        var cy = rect.top  + rect.height / 2;
        applyZoom(scale + (ZOOM_STEP * direction), cx, cy);
    };

    // ── Instruction Hint ──
    function showHint() {
        var multiNote = currentPages.length > 1 ? '  •  Use ‹ › to flip pages' : '';
        if (isTouchDevice()) {
            hint.textContent = 'Pinch to Zoom  •  Drag to Pan  •  Double-tap to Toggle' + multiNote;
        } else {
            hint.textContent = 'Scroll to Zoom  •  Drag to Pan  •  Use +/\u2212 Buttons' + multiNote;
        }
        hint.classList.remove('fade-out');
        if (hintTimer) clearTimeout(hintTimer);
        hintTimer = setTimeout(function () {
            hint.classList.add('fade-out');
        }, HINT_DURATION);
    }

    /* ─────────────────────────────────────────────
       DESKTOP — Mouse Wheel Zoom
       ───────────────────────────────────────────── */
    wrapper.addEventListener('wheel', function (e) {
        e.preventDefault();
        var direction = e.deltaY < 0 ? 1 : -1;
        applyZoom(scale * (1 + ZOOM_STEP * direction * 0.5), e.clientX, e.clientY);
    }, { passive: false });

    /* ─────────────────────────────────────────────
       DESKTOP — Mouse Drag to Pan
       ───────────────────────────────────────────── */
    img.addEventListener('mousedown', function (e) {
        if (scale <= MIN_SCALE) return;
        e.preventDefault();
        isPanning = true;
        panStartX = e.clientX - pointX;
        panStartY = e.clientY - pointY;
        img.classList.add('is-panning');
    });

    wrapper.addEventListener('mousemove', function (e) {
        if (!isPanning) return;
        e.preventDefault();
        pointX = e.clientX - panStartX;
        pointY = e.clientY - panStartY;
        constrainPan();
        updateTransform();
    });

    function endMousePan() {
        isPanning = false;
        img.classList.remove('is-panning');
    }
    wrapper.addEventListener('mouseup',    endMousePan);
    wrapper.addEventListener('mouseleave', endMousePan);

    /* ─────────────────────────────────────────────
       MOBILE — Touch: Pinch + Pan + Double-Tap
       ───────────────────────────────────────────── */
    wrapper.addEventListener('touchstart', function (e) {
        if (e.touches.length === 2) {
            e.preventDefault();
            initialPinchDist  = getDistance(e.touches[0], e.touches[1]);
            initialPinchScale = scale;
        } else if (e.touches.length === 1) {
            var now = Date.now();
            var timeSince = now - lastTouchEnd;
            touchPanning = false;

            if (timeSince < DBL_TAP_DELAY && timeSince > 0) {
                e.preventDefault();
                handleDoubleTap(e.touches[0].clientX, e.touches[0].clientY);
                lastTouchEnd = 0;
                return;
            }

            if (scale > MIN_SCALE) {
                touchPanning = true;
                panStartX = e.touches[0].clientX - pointX;
                panStartY = e.touches[0].clientY - pointY;
            }
        }
    }, { passive: false });

    wrapper.addEventListener('touchmove', function (e) {
        if (e.touches.length === 2 && initialPinchDist !== null) {
            e.preventDefault();
            var dist     = getDistance(e.touches[0], e.touches[1]);
            var midX     = (e.touches[0].clientX + e.touches[1].clientX) / 2;
            var midY     = (e.touches[0].clientY + e.touches[1].clientY) / 2;
            applyZoom(initialPinchScale * (dist / initialPinchDist), midX, midY);
        } else if (e.touches.length === 1 && touchPanning && scale > MIN_SCALE) {
            e.preventDefault();
            pointX = e.touches[0].clientX - panStartX;
            pointY = e.touches[0].clientY - panStartY;
            constrainPan();
            updateTransform();
        }
    }, { passive: false });

    wrapper.addEventListener('touchend', function (e) {
        if (e.touches.length < 2) { initialPinchDist = null; }
        if (e.touches.length === 0) {
            touchPanning = false;
            lastTouchEnd = Date.now();
        }
    });

    function getDistance(t1, t2) {
        var dx = t1.clientX - t2.clientX;
        var dy = t1.clientY - t2.clientY;
        return Math.sqrt(dx * dx + dy * dy);
    }

    function handleDoubleTap(cx, cy) {
        if (scale > MIN_SCALE) { resetZoom(); }
        else { applyZoom(DBL_TAP_SCALE, cx, cy); }
    }

    /* ─────────────────────────────────────────────
       KEYBOARD — Escape, Left/Right arrows
       ───────────────────────────────────────────── */
    document.addEventListener('keydown', function (e) {
        if (modal.style.display !== 'block') return;

        if (e.key === 'Escape') {
            closeZoomModal();
        } else if (e.key === 'ArrowLeft' && currentPages.length > 1) {
            changePage(-1);
        } else if (e.key === 'ArrowRight' && currentPages.length > 1) {
            changePage(1);
        }
    });

    /* Close on backdrop click */
    wrapper.addEventListener('click', function (e) {
        if (e.target === wrapper && scale <= MIN_SCALE) {
            closeZoomModal();
        }
    });

    /* Prevent ghost image drag */
    img.addEventListener('dragstart', function (e) { e.preventDefault(); });

})();

/* =========================================
   BURGER MENU FIX (unchanged)
   ========================================= */
$(document).ready(function() {
    $(".menu-button__hldr, .menu-btn").off('click').on('click', function(e) {
        e.preventDefault();
        e.stopPropagation();
        var menu = $(".menu-hldr");
        if (menu.is(":visible")) {
            menu.fadeOut(300).removeClass("active");
        } else {
            menu.fadeIn(300).addClass("active");
            menu.css('display', 'block');
        }
    });

    $(".menu-close, .close-text").off('click').on('click', function(e) {
        e.preventDefault();
        $(".menu-hldr").fadeOut(300).removeClass("active");
    });
});
</script>

<?php include "template/footer.php"; ?>