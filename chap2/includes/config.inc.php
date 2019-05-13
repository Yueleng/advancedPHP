<?php # Script 2.1 - config.inc.php

/**
 * File name: confdig.inc.php
 * Created by: Yueleng Wang
 * Contact: wangyueleng@gmail.com
 * Last modified: April 28, 2019
 * 
 * Configuration file does the following things:
 * - Has site settings in one location.
 * - Stores URLs and URIs as constants.
 * - Sets how errors will be handled.
 * 
 * 
 * # ************************ #
 * # ******* SETTTINGS ****** #
 * 
 * 
 */

// Errors  are emailed here:
$contact_email = 'wangyueleng@gmail.com';

// Determine whether we're working on a local server
$host = substr($_SERVER['HTTP_HOST'], 0, 5);
if (in_array($host, array('local', '127.0', '192.1'))) {
    $local = true;
} else {
    $local = false;
};

// Determine location of files and the URL of the site:
// Allow for development of different servers.
if ($local) {
    // Always debug when running locally:
    $debug = TRUE;

    // Define the constants
    define('BASE_URI', 'C:/Apache24/htdocs/advancedPHP/');
    define('BASE_URL', 'http://localhost/advancedPHP/');
    define('DB', 'C:/Apache24/htdocs/advancedPHP/db.inc.php');

} else {

    define('BASE_URI', '/path/to/html/folder/');
    define('BASE_URL', 'http://www.example.com/');
    define('DB', '/path/to/live/db.inc.php');
}

/**
 * 
 * Most important setting!
 * The $debug variable is used to set error management.
 * To debug a specific page, add this to the index.php page:
 * 
 * if ($p == 'thismodule') $debug = TRUE;
 * require('./includes/config.inc.php')
 * 
 * To debug t he entire site, do
 * 
 * $debug = TRUE;
 * 
 * before this next conditional.
 * 
 */

// Assume debugging is off.
if (!isset($debug)) {
    $debug = FALSE;
}


# ******* SETTTINGS ****** #
# ************************ #

# ****************************** #
# ****** ERROR MANAGEMENT ****** #

// Create the error handler:
function my_error_handler($e_number, $e_message, $e_file, $e_line, $e_vars) {
    global $debug, $contact_email;


    // Build the error message:
    $message = "An error occured in script '$efile' on line $e_line: $e_message";

    // Append $e_vars to the $message:
    $message .= print_r($e_vars, 1);

    if ($debug) { // Show the error.
        echo '<div class="error">' . $message . '</div>';
        debug_print_backtrace();
    } else {
        // Log the error:
        error_log($message, 1, $contact_email); // Send email.
        
        // Only print an error message if the error isn't a notice or strict.
        if ( ($e_number != E_NOTICE) && ($e_number < 2048) ) {
            echo '<div class="error"> A system error occured. We apologize for the inconvenience. </div>';

        } 

    } // End of debug if.

} //End of my_error_handler() definition;
set_error_handler('my_error_handler');


# ****** ERROR MANAGEMENT ****** #
# ****************************** #
