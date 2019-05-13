<?php # Script 2.4 - index.php
/**
 * This is the main page
 * This page includes the configuration file
 * the templates, and any content-specific modules.
 */

 // Require the configuration file before any PHP code:
require('./chap2/includes/config.inc.php');

// Validate what page to show:
if (isset($_GET['p'])) {
    $p = $_GET['p'];
} elseif (isset($_POST['p'])) {
    // FORMS
    $p = $_POST['p'];
} else {
    $p = NULL;
}

# Determine what page is display:
switch ($p) {
    case 'about':
        $page = 'about.inc.php';
        $page_tile = 'About This Site';
        break;
    
    case 'contact':
        $page = 'contact.inc.php';
        $page_tile = 'Contact us';
        break;

    case 'search':
        $page = 'search.inc.php';
        $page_tile = 'Search Results';
        break;

    // Default is to include the main page.
    default:
        $page = 'main.inc.php';
        $page_title = 'Site Home Page';
        break;
} // End of main switch.

// Make sure the file exists:
if (!file_exists('./chap2/modules/' . $page)) {
    $page = 'main.inc.php';
    $page_title = 'Site Home Pages';
}

// Include the header file:
include('./chap2/includes/header.html');

// Include the content-specific module:
// $page is determined from the above switch.

include('./chap2/modules/' . $page);

// Include the footer file to complete the template:
include('./chap2/includes/footer.html');

