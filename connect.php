<?php
class DbConnect{

 public $host = "@ec2-52-20-195-51.compute-1.amazonaws.com"; 
 public $user = getenv(DB_USERNAME); 
 public $password = getenv(DB_PASSWORD); 
 public $dbname = "myflixdb"; 
 

 public function connect(){
    try {
        $conn = new PDO('mysql:host=' . $this->host . '; dbname=' . $this->dbname, $this->user, $this->password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch( PDOException $e) {
        echo 'Database Error: ' . $e->getMessage();
    }
}
}
?>
