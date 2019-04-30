<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Sorting  Multidimensional Arrays</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php # Script 1.5 - sort_lambda.php
/**
 * This page creates a multidimensional array
 * of names and grades.
 * The array is then sorted twice:
 * once by name and once by grade.
*/

// Create the array...
// Array structure:
// studentID => array('name' => 'Name', 'grade' => XX.X)
$students = array(
    256 => array('name' => 'Jon', 'grade' => 98.5),
    2   => array('name' => 'Vance', 'grade' => 85.1),
    9   => array('name' => 'Stephen', 'grade' => 94.0),
    364   => array('name' => 'Steve', 'grade' => 85.1),
    68  => array('name' => 'Rob', 'grade' => 74.6)
);

// Name sorting function
// strcasecmp - Binary safe case-insensitive string comparison
function name_sort($x, $y) {
    static $count = 1;

    echo "<p> Iteration $count: {$x['name']} vs {$y['name']} </p>";
    $count++;
    return strcasecmp($x['name'], $y['name']);
}

// Grade sorting function
// Sort in DESCENDING order!
function grade_sort($x, $y){
    static $count = 1;

    echo "<p> Iteration $count: {$x['grade']} vs {$y['grade']} </p>";
    $count++;
    
    return ($x['grade'] < $y['grade']);

    /**
     * Explanation:
     * if $x['grade'] < $y['grade'], return true which means $y is before $x
     * if $x['grade'] > $y['grade'], return false, $x is before $y. 
     * if $x['grade'] === $y['grade'], return false, $x is before $y. 
     * Thus sort in descending order.
     */
}

// Print the array as is: 
echo '<h2> Array As Is </h2> <pre>' . print_r($students, 1) . '</pre>';

// Sort by name:
uasort($students, function($x, $y) {
    return strcasecmp($x['name'], $y['name']);
});
echo '<h2> Array Sorted By Name </h2> <pre>' . print_r($students, 1) . '</pre>';

// Sort by grade:
uasort($students, function($x, $y){
    return ($x['grade'] < $y['grade']);
});
echo '<h2> Array Sorted By Grade(Descending order) </h2> <pre>' . print_r($students, 1) . '</pre>';
?>
</body>
</html>