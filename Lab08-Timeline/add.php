<?php
# Ex 4 : Write a tweet
include 'timeline.php';
$timeline = new Timeline();
try {
	$tweet = array();
	$author = $_POST["author"];
	$content = $_POST["content"];	
    if (preg_match("/^[a-z](?!.*--)[a-z -]{1,19}$/i", $author) and !preg_match("/</", $content)) {
		array_push($tweet, $author);
		array_push($tweet, $content);
        $timeline->add($tweet);
        header("Location:index.php");
    } else {
        header("Location:error.php");
    }
} catch(Exception $e) {
	header("Location:error.php");
}
?>

