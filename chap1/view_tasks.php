<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>View Tasks</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h2>Current To-Do List</h2>
<?php # Script 1.3 - view_tasks.php

/**
 * This page shows all existing tasks.
 * A recursive function is used to show the 
 * tasks as nested lists, as applicable.
 */


// Connect to database
$config = parse_ini_file(__DIR__ . '/config.ini');
$dbConnection = mysqli_connect($config['hostname'], $config['username'], $config['password'], $config['schema']);

// Retrieve all the uncompleted tasks:
$query = 'SELECT task_id, parent_id, task FROM tasks WHERE date_completed = "0000-00-00 00:00:00" 
          ORDER BY parent_id, date_added ASC'; // ASC is by default
$r = mysqli_query($dbConnection, $query);

// Initialize the storage array;
$tasks = array();

// Loop through the result:
while (list($task_id, $parent_id, $task) = mysqli_fetch_array($r, MYSQLI_NUM)) {
    $tasks[$parent_id][$task_id] = $task;
}
    
// FOR DEBUGGING:
echo '<pre>' . print_r($tasks, 1) . '</pre>';

// Send the first array element
// to the makelist() function:
make_list($tasks[0], $tasks);


// Function for displaying a list
// Receives one argument: an array.

function make_list($parent, $all = null) {
    // Need the main $tasks array:
    static $tasks;
    if (isset($all)) {
        $tasks = $all;
    }

    echo '<ol>'; // Start an ordered list;
    
    // Loop through each subarray:
    foreach ($parent as $task_id => $todo) {
        // Display the item:
        echo "<li> $todo";

        // Check for subtasks:
        if(isset($tasks[$task_id])) {
            // Call this function again:
            make_list($tasks[$task_id]);
        }

        echo '</li>'; // Complete the list item.
    }

    echo '</ol>';
}

?>