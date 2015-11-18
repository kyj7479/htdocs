<?php
    class TimeLine {
        # Ex 2 : Fill out the methods
        private $db;
        function __construct()
        {
            # You can change mysql username or password
            $this->db = new PDO("mysql:host=localhost;dbname=timeline", "root", "root");
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        public function add($tweet) // This function inserts a tweet
        {
            $this->db->exec("INSERT INTO tweets(author, contents, time) VALUES('$tweet[0]', '$tweet[1]', now());");
        }
        public function delete($no) // This function deletes a tweet
        {
            $this->db->exec("DELETE FROM tweets WHERE no = '$no'");
        }
        # Ex 6: hash tag
        # Find has tag from the contents, add <a> tag using preg_replace() or preg_replace_callback()
        public function loadTweets() // This function load all tweets
        {
			$q = "SELECT * FROM tweets ORDER BY time DESC";
			$result = $this->db->query($q);
			return $result;

        }
        public function searchTweets($type, $query) // This function load tweets meeting conditions
        {
        	$rows=$this->db->query("SELECT * FROM tweets WHERE $type like '%$query%' order by time desc");
            return $rows;
        }
    }
?>
