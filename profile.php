<?php

require 'vendor/autoload.php';

use MongoDB\Client;

$mongoClient = new Client("mongodb://ec2-44-221-241-112.compute-1.amazonaws.com:27017");

$database = $mongoClient->myflix;
$collectionName = 'horror';

$videos = $database->{$collectionName}->find();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyFlix Video Library</title>
</head>
<body>
    <h1>MyFlix Video Library</h1>

    <div class="video-container">
        <?php foreach ($videos as $video): ?>
            <div class="video">
                <video controls>
                    <source src="<?php echo $video['url']; ?>" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
                <p><?php echo $video['title']; ?></p>
            </div>
        <?php endforeach; ?>
    </div>

        
    </div>
</body>
</html>