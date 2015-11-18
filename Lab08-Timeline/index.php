<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Simple Timeline</title>
        <link rel="stylesheet" href="timeline.css">
    </head>
    <body>
    	<?php
    	include 'timeline.php';
		$timeline = new Timeline();
		?>
        <div>
            <a href="index.php"><h1>Simple Timeline</h1></a>
            <div class="search">
                <!-- Ex 3: Modify forms -->
                <form class="search-form" action="index.php" method="get">
                    <input type="submit" value="search">
                    <input type="text" name="query" placeholder="Search">
                    <select name="type">
                        <option value="author">Author</option>
                        <option value="contents">Content</option>
                    </select>
                </form>
            </div>
            <div class="panel">
                <div class="panel-heading">
                    <!-- Ex 3: Modify forms -->
                    <form class="write-form" action="add.php" method="post">
                        <input type="text" placeholder="Author" name="author">
                        <div>
                            <input type="text" placeholder="Content" name="content">
                        </div>
                        <input type="submit" value="write">
                    </form>
                </div>
                <!-- Ex 3: Modify forms & Load tweets -->
                <?php
                $type = $_GET["type"];
                $query = $_GET["query"];
				if(isset($type) and isset($query)) {
					$rows = $timeline->searchTweets($type, $query);
				}
				else {
					$rows = $timeline->loadTweets();
				}
                foreach ($rows as $key => $value) { ?>
                <div class="tweet">
                    <form class="delete-form" action="delete.php" method="post">
                        <input type="submit" value="delete">
                        <input type="hidden" name="number" value="<?php echo $value["no"] ?>">
                    </form>
                    <div class="tweet-info">
                        <span><?php echo $value["author"] ?></span>
                        <span><?php echo date('H:i:s d/m/Y', strtotime($value["time"])) ?></span>
                    </div>
                    <div class="tweet-content">
                        <?php echo preg_replace("/#([_]*[a-zA-Z0-9가-힣]+[\w가-힣]*)/", "<a href='index.php?query=\\0&type=content'>\\0</a>", $value['contents'])?>
                    </div>
                </div>          	
                <?php } ?>
            </div>
        </div>
    </body>
</html>
