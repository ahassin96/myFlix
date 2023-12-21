<?php

require 'vendor/autoload.php';


use MongoDB\Client;

$mongoClient = new Client("mongodb://ec2-44-221-241-112.compute-1.amazonaws.com:27017");


$database = $mongoClient->myflix;


$collection = $database->children;



$cursor = $collection->find();


foreach ($cursor as $document) {
    var_dump($document);
}
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<p>	This is profile </p>
</body>
</html>