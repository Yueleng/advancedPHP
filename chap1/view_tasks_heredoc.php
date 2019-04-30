<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>View Tasks</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h2>Current To-Do List</h2>
<?php # Script 1.6 - view_tasks_heredoc.php

/**
 * This page shows all existing tasks.
 * A recursive function is used to show the 
 * tasks as nested lists, as applicable.
 * Tasks can now be marked as completed.
 */


// Connect to database
$config = parse_ini_file(__DIR__ . '/config.ini');
$dbConnection = mysqli_connect($config['hostname'], $config['username'], $config['password'], $config['schema']);

// Check if the form has been submitted:
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tasks']) 
    && is_array($_POST['tasks']) && !empty($_POST['tasks'])) {
    $q = "UPDATE tasks SET date_completed = utc_timestamp() WHERE task_id IN (";

    // Add each task ID:
    foreach($_POST['tasks'] as $task_id => $v) {
        $q .= $task_id . ", ";
    }

    // Complete the query and execute
    $q = substr($q, 0, -2) . ')';
    $r = mysqli_query($dbConnection, $q);

    // Report on the results:
    if (mysqli_affected_rows($dbConnection) === count($_POST['tasks'])) {
        echo '<p>The task(s) have been marked as completed!</p>';
    } else {
        echo '<p>Not all tasks could be marked as completed!</p>';
    }

} // End of submission IF.

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
// echo '<pre>' . print_r($tasks, 1) . '</pre>';

// Make a form:
echo <<<EOT
<p>Check the box next to a task and click "Update" to make a task as completed(it, and any subtasks,
will no longer appear in this list). </p>
<form action="view_tasks_heredoc.php" method="post">
EOT;

// Send the first array element
// to the makelist() function:
make_list($tasks[0], $tasks);

// Complete the form
echo <<<EOT
<input name="submit" type="submit" value="Update"/>
</form>
EOT;

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
        // echo "<li> $todo";

        // Start with a checkbox:
        echo <<<EOT
<li><input type="checkbox" name="tasks[$task_id] value="done"> $todo
EOT;


        // Check for subtasks
        if(isset($tasks[$task_id])) {
            // Call this function again:
            make_list($tasks[$task_id]);
        }

        echo '</li>'; // Complete the list item.
    }

    echo '</ol>';
}

?>