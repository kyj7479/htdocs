<!DOCTYPE html>
<html>
	<head>
		<title>Grade Store</title>
		<link href="http://selab.hanyang.ac.kr/courses/cse326/2015/problems/pResources/gradestore.css" type="text/css" rel="stylesheet" />
	</head>

	<body>
		<?php
		# Ex 4 : 
		# Check the existance of each parameter using the PHP function 'isset'.
		# Check the blankness of an element in $_POST by comparing it to the empty string.
		# (can also use the element itself as a Boolean test!)
		$name = $_POST["name"];
		$id = $_POST["id"];
		$names = ["cse326", "cse107", "cse603", "cin870"];
		$grade = $_POST["grade"];
		$creditNum = $_POST["creditNum"];
		$cc = $_POST["cc"];
		
		if (!strcmp($name, "") || !strcmp($id, "") || !strcmp($creditNum, "")) {
		?>
			<h1>Sorry</h1>
			<p>You didn't fill out the form completely. Try again?</p>

		<?php
		# Ex 5 : 
		# Check if the name is composed of alphabets, dash(-), ora single white space.
		} elseif (!preg_match("/^[a-z][a-z -]*$/i", $name)) { 
		?>
			Display the below error message : 
			<h1>Sorry</h1>
			<p>You didn't provide a valid name. Try again?</p>

		<?php
		# Ex 5 : 
		# Check if the credit card number is composed of exactly 16 digits.
		# Check if the Visa card starts with 4 and MasterCard starts with 5.
		} elseif (!preg_match_all("/\d{16}/", $creditNum) || !(($cc=="Visa" && $creditNum[0]=="4") || ($cc=="MasterCard" && $creditNum[0]=="5"))) {
		?>
			Display the below error message : 
			<h1>Sorry</h1>
			<p>You didn't provide a valid credit card number. Try again?</p>

		<?php
		# if all the validation and check are passed 
		} else {
		?>

		<h1>Thanks, looser!</h1>
		<p>Your information has been recorded.</p>
		
		<!-- Ex 2: display submitted data -->
		<ul> 
			<li>Name: <?=$name?></li>
			<li>ID: <?=$id?></li>
			<!-- use the 'processCheckbox' function to display selected courses -->
			<li>Course: <?=processCheckbox($names)?></li>
			<li>Grade: <?=$grade?></li>
			<li>Credit <?=$creditNum?>(<?=$cc?>)</li>
		</ul>
		
			<p>Here are all the loosers who have submitted here:</p>
		<?php
			$filename = "loosers.txt";
			/* Ex 3: 
			 * Save the submitted data to the file 'loosers.txt' in the format of : "name;id;cardnumber;cardtype".
			 * For example, "Scott Lee;20110115238;4300523877775238;visa"
			 */
			 file_put_contents("loosers.txt", $name.";".$id.";".$creditNum.";".$cc."\n", FILE_APPEND); 
		?>
		
		<!-- Ex 3: Show the complete contents of "loosers.txt".
			 Place the file contents into an HTML <pre> element to preserve whitespace -->
		<?php
			$lines = file($filename);
			
			foreach ($lines as $key) { ?>
				<p><?=$key?></p>
		<?php }
		
			/* Ex 2: 
			 * Assume that the argument to this function is array of names for the checkboxes ("cse326", "cse107", "cse603", "cin870")
			 * 
			 * The function checks whether the checkbox is selected or not and 
			 * collects all the selected checkboxes into a single string with comma seperation.
			 * For example, "cse326, cse603, cin870"
			 */
		}
		function processCheckbox($names){
			$result = "";
			foreach ($names as $key) {
				$check = $_POST[$key];
				if(isset($check)) {
					if($result=="") {
						$result = $check;
					}
					else {
						$result = $result.", ".$check;
					}
				}
			}
			return $result;
		}
		?>
		
	</body>
</html>
