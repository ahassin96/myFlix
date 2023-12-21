<?php

require 'vendor/autoload.php';


use MongoDB\Client;

$mongoClient = new Client("mongodb://ec2-44-221-241-112.compute-1.amazonaws.com:27017");


$database = $mongoClient->myflix;


$collection = $database->children;

$videos = $collection->find();

?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<p>	This is profile </p>
	<?php foreach ($videos as $video): ?>
    <div>
        <h2><?= $video['title']; ?></h2>
        <p><?= $video['description']; ?></p>
        <a href="watch.php?url=<?= urlencode($video['url']); ?>">Watch Video</a>
    </div>
<?php endforeach; ?>
</body>
</html>