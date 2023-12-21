<?php

require 'vendor/autoload.php';

$mongoClient = new MongoDB\Client("mongodb://localhost:27017");


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