<?php
# Ex 5 : Delete a tweet
include 'timeline.php';
$timeline = new Timeline();
try {
	$number = $_POST["number"];
	$timeline->delete($number);
    header("Location:index.php");
} catch(Exception $e) {
    header("Location:error.php");
}
?>
