<?php


// Path: components\title.components
// Get the current page name
$page_name = basename($_SERVER['PHP_SELF']);



// Set the title of the page
switch ($page_name) {
    case 'index.php':
        $title = 'Home | Sentinel Automation';
        break;
    case 'about.php':
        $title = 'About Us | Sentinel Automation';
        break;
    case 'products.php':
        $title = 'Systems & Services | Sentinel Automation';
        break;

    case 'projects.php':
        $title = 'Projects | Sentinel Automation';
        break;

    case 'projects-details.php':
        $title = 'Projects | Sentinel Automation';
        break;

    case 'contact-us.php':
        $title = 'Contact Us | Sentinel Automation';
        break;


    default:
        $title = 'Sentinel Automation';
}

// Echo the title
echo '<title>' . $title . '</title>';
