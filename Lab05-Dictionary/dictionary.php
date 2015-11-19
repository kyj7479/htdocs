<!DOCTYPE html>
<html>
<head>
    <title>Dictionary</title>
    <meta charset="utf-8" />
    <link href="dictionary.css" type="text/css" rel="stylesheet" />
</head>
<body>
<div id="header">
    <h1><?php $filename = "My Dictionary"; print $filename ?></h1>
<!-- Ex. 1: File of Dictionary -->
	<p>
    <?php
    	$file = file("dictionary.tsv");
		$lines = count($file);
		$size = filesize("dictionary.tsv");
		print "$filename has $lines total words
		and
		size of $size bytes."
    ?>
    </p>
</div>
<div class="article">
    <div class="section">
        <h2>Today's words</h2>
<!-- Ex. 2: Today’s Words & Ex 6: Query Parameters -->
		<ol>
		<?php
            function getWordsByNumber($listOfWords, $numberOfWords){
                $resultArray = array();
				$resultArray = array_slice($listOfWords, $numberOfWords);
                return $resultArray;
            }
		?>
		<?php
			$ran_int = $_GET["number_of_words"];
			if(!isset($ran_int) or $ran_int=="") { $ran_int = 3; }
			$resultArray = getWordsByNumber($file, $ran_int);
			foreach ($resultArray as $line) { ?>
				<li><?=$line?></li>
		<?php } ?>
		</ol>
    </div>
    <div class="section">
        <h2>Searching Words</h2>
<!-- Ex. 3: Searching Words & Ex 6: Query Parameters -->
        <?php
            function getWordsByCharacter($listOfWords, $startCharacter){
                $resultArray = array();
		        foreach($listOfWords as $line) {
		        	if ($line[0] == $startCharacter) {
		        		array_push($resultArray, $line);
		        	}
		        }
                return $resultArray;
            }
			
			$character = $_GET["character"];
			if(!isset($character) or $character=="") { $character = "C"; }
        ?>
        <p>
            Words that started by <strong>'<?=$character?>'</strong> are followings :
        </p>
        <ol>
		<?php
			$resultArray = getWordsByCharacter($file, $character);
			foreach ($resultArray as $line) { ?>
				<li><?=$line?></li>
		<?php } ?>
        </ol>
    </div>
    <div class="section">
        <h2>List of Words</h2>
<!-- Ex. 4: List of Words & Ex 6: Query Parameters -->
        <?php
            function getWordsByOrder($listOfWords, $orderby){
                $resultArray = $listOfWords;
				if($orderby == 1) { rsort($resultArray); }
				else { sort($resultArray); }
                return $resultArray;
            }
			
			$orderby = $_GET["orderby"];
			$orderby_string = "alphabetical order";
			if(!isset($orderby) or $orderby=="") { $orderby = 0; }
			if($orderby==1) { $orderby_string = "back ".$orderby_string; }
        ?>
        <p>
            All of words ordered by <strong><?=$orderby_string?></strong> are followings :
        </p>
        <ol>
		<?php
			$resultArray = getWordsByOrder($file, $orderby);
			foreach ($resultArray as $line) {
				$tokens = explode("\t", $line);
				if(strlen($tokens[0]) > 6) { ?>
					<li class="long"><?=$line?></li>
				<?php }
				else { ?>
					<li><?=$line?></li>
				<?php }
		} ?>   
        </ol>
    </div>
    <div class="section">
        <h2>Adding Words</h2>
<!-- Ex. 5: Adding Words & Ex 6: Query Parameters -->
		<?php
			$newWord = $_GET["new_word"];
			$meaning = $_GET["meaning"];
			
			if (isset($newWord) && isset($meaning)) {
				file_put_contents("dictionary.tsv", "\n".$newWord."\t".$meaning, FILE_APPEND); ?>
				<p>Adding a word is success!</p>

			<?php }
			else { ?>
				<p>Input word or meaning of the word doesn't exist.</p>
			<?php } ?>
    </div>
</div>
<div id="footer">
    <a href="http://validator.w3.org/check/referer">
        <img src="http://selab.hanyang.ac.kr/courses/cse326/2015/problems/images/w3c-html.png" alt="Valid HTML5" />
    </a>
    <a href="http://jigsaw.w3.org/css-validator/check/referer">
        <img src="http://selab.hanyang.ac.kr/courses/cse326/2015/problems/images/w3c-css.png" alt="Valid CSS" />
    </a>
</div>
</body>
</html>