<?php
include "template/header-dark.php";
// We don't strictly need image-carousel.php for this new layout, but we include it if it has dependencies.
// include "image-carousel.php"; 

// 1. FETCH DATA DIRECTLY
// We grab all systems at once. This is faster and prevents the "endless scroll" issue.
$sql = "SELECT * FROM productslist ORDER BY id ASC";
$result = $conn->query($sql);

$systems = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $systems[] = $row;
    }
}
?>

<!-- CUSTOM CSS: MASTER-DETAIL DASHBOARD -->
<style>
    /* Reset & Base */
    body { background-color: #f9f9f9; }
    
    /* Layout Container */
    .dashboard-container {
        display: flex;
        height: 85vh; /* Fixed height relative to viewport */
        max-width: 1600px;
        margin: 20px auto;
        background: #ffffff;
        box-shadow: 0 10px 30px rgba(0,0,0,0.08);
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid #eaeaea;
    }

    /* LEFT SIDEBAR */
    .sidebar {
        width: 360px;
        background: #ffffff;
        border-right: 1px solid #e1e1e1;
        display: flex;
        flex-direction: column;
        flex-shrink: 0;
        z-index: 5;
    }

    .sidebar-header {
        padding: 25px;
        border-bottom: 1px solid #f0f0f0;
        background: #fff;
    }

    .sidebar-title {
        font-size: 18px;
        font-weight: 800;
        color: #162747; /* Sentinel Dark Blue */
        margin: 0;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .sidebar-list {
        overflow-y: auto; /* Internal scrolling */
        flex: 1;
    }

    /* List Items */
    .nav-item {
        display: flex;
        align-items: center;
        padding: 18px 25px;
        cursor: pointer;
        transition: all 0.2s ease;
        border-bottom: 1px solid #f9f9f9;
        position: relative;
    }

    .nav-item:hover {
        background-color: #f4f7f6;
    }

    .nav-item.active {
        background-color: #eefcf3; /* Light Green Background */
        border-left: 5px solid #28a745; /* Sentinel Green */
    }

    .nav-item img {
        width: 45px;
        height: 45px;
        object-fit: contain;
        margin-right: 15px;
        filter: grayscale(100%);
        opacity: 0.7;
        transition: 0.3s;
    }

    .nav-item.active img {
        filter: none;
        opacity: 1;
        transform: scale(1.1);
    }

    .nav-text h4 {
        margin: 0;
        font-size: 15px;
        font-weight: 600;
        color: #333;
    }

    .nav-text p {
        margin: 3px 0 0;
        font-size: 12px;
        color: #888;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* RIGHT CONTENT PANEL */
    .content-panel {
        flex: 1;
        padding: 60px 80px;
        overflow-y: auto;
        background-color: #fff;
        position: relative;
    }

    .content-wrapper {
        max-width: 900px;
        margin: 0 auto;
        animation: fadeIn 0.4s ease-out;
    }

    .content-header h1 {
        font-size: 42px;
        font-weight: 700;
        color: #162747;
        margin-bottom: 30px;
        border-bottom: 3px solid #28a745;
        display: inline-block;
        padding-bottom: 10px;
    }

    .main-image {
        width: 100%;
        max-height: 450px;
        object-fit: contain;
        border-radius: 10px;
        margin-bottom: 40px;
        background: #fafafa;
        padding: 20px;
    }

    .description-text {
        font-size: 18px;
        line-height: 1.8;
        color: #444;
        text-align: justify;
    }

    /* Responsive Adjustments */
    @media (max-width: 992px) {
        .dashboard-container {
            flex-direction: column;
            height: auto;
        }
        .sidebar {
            width: 100%;
            height: 300px;
            border-right: none;
            border-bottom: 1px solid #ddd;
        }
        .content-panel {
            padding: 30px;
        }
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<div class="spacing"></div>

<!-- MAIN UI STRUCTURE -->
<div class="dashboard-container">
    
    <!-- LEFT LIST -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h3 class="sidebar-title">Systems & Services</h3>
        </div>
        <div class="sidebar-list">
            <?php if (!empty($systems)): ?>
                <?php foreach ($systems as $index => $sys): ?>
                    <div class="nav-item <?php echo $index === 0 ? 'active' : ''; ?>" 
                         onclick="showSystem(this)"
                         data-title="<?php echo htmlspecialchars($sys['ps_header']); ?>"
                         data-img="<?php echo htmlspecialchars($sys['img_source']); ?>"
                         data-desc="<?php echo htmlspecialchars($sys['ps_content']); ?>">
                        
                        <!-- Thumbnail -->
                        <img src="<?php echo htmlspecialchars($sys['img_source']); ?>" alt="icon">
                        
                        <div class="nav-text">
                            <h4><?php echo $sys['ps_header']; ?></h4>
                            <p>Click to view details</p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div style="padding:20px;">No systems found.</div>
            <?php endif; ?>
        </div>
    </div>

    <!-- RIGHT DETAIL VIEW -->
    <div class="content-panel">
        <div class="content-wrapper" id="contentArea">
            <!-- Content loaded via JS -->
        </div>
    </div>

</div>

<!-- JAVASCRIPT LOGIC -->
<script>
    // 1. Initialize View on Load
    document.addEventListener("DOMContentLoaded", function() {
        const firstItem = document.querySelector('.nav-item.active');
        if(firstItem) {
            showSystem(firstItem);
        }

        // --- BURGER MENU FIX ---
        // Your header uses a button with class .navbar-toggler or .menu-btn
        // We manually attach a click listener to ensure it works even if other scripts fail.
        
        // Find the open button
        const menuBtns = document.querySelectorAll('.menu-btn, .navbar-toggler');
        const menuContainer = document.querySelector('.menu-hldr');
        const closeBtn = document.querySelector('.menu-close');

        if(menuContainer) {
            // Function to open menu
            const openMenu = (e) => {
                e.preventDefault(); // Stop any bootstrap conflicts
                menuContainer.style.display = 'block'; // Or however your CSS handles it
                menuContainer.classList.add('active'); // Common convention
                // Based on your header code, it might use specific animation classes
                // but setting display:block usually forces it visible if CSS is tricky.
                
                // If your theme uses jQuery fade:
                if(typeof $ !== 'undefined') {
                    $('.menu-hldr').fadeIn();
                }
            };

            // Function to close menu
            const closeMenu = () => {
                if(typeof $ !== 'undefined') {
                    $('.menu-hldr').fadeOut();
                } else {
                    menuContainer.style.display = 'none';
                    menuContainer.classList.remove('active');
                }
            };

            // Attach listeners
            menuBtns.forEach(btn => btn.addEventListener('click', openMenu));
            if(closeBtn) closeBtn.addEventListener('click', closeMenu);
        }
    });

    // 2. Logic to Switch Content
    function showSystem(element) {
        // Highlight Sidebar Item
        document.querySelectorAll('.nav-item').forEach(el => el.classList.remove('active'));
        element.classList.add('active');

        // Extract Data
        const title = element.getAttribute('data-title');
        const img = element.getAttribute('data-img');
        const desc = element.getAttribute('data-desc'); // Contains HTML

        // Render Content
        const contentArea = document.getElementById('contentArea');
        
        // Simple Fade Out/In logic could be added here
        contentArea.innerHTML = `
            <div class="content-header">
                <h1>${title}</h1>
            </div>
            <img src="${img}" class="main-image" alt="${title}" onerror="this.src='assets/no-image.png'">
            <div class="description-text">
                ${decodeHtml(desc)}
            </div>
        `;
    }

    // Helper for HTML entities
    function decodeHtml(html) {
        var txt = document.createElement("textarea");
        txt.innerHTML = html;
        return txt.value;
    }
</script>

<?php include "template/footer.php"; ?>