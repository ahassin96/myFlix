<?php

require 'vendor/autoload.php';

use MongoDB\Client;

$mongoClient = new Client("mongodb://ec2-44-221-241-112.compute-1.amazonaws.com:27017");

$database = $mongoClient->myflix;
$horrorVideos = $database->horror->find();
$militaryVideos = $database->military->find();
$actionVideos = $database->action->find();


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

    <div class="video-container" id="comedy-container">
        <?php foreach ($militaryVideos as $video): ?>
            <div class="video">
                <video controls>
                    <source src="<?php echo $video['url']; ?>" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="video-container" id="action-container">
        <?php foreach ($actionVideos as $video): ?>
            <div class="video">
                <video controls>
                    <source src="<?php echo $video['url']; ?>" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="video-container" id="horror-container">
        <?php foreach ($horrorVideos as $video): ?>
            <div class="video">
                <video controls>
                    <source src="<?php echo $video['url']; ?>" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>
        <?php endforeach; ?>
    </div>


    <script>
        function scrollVideos(containerId, direction) {
            const container = document.getElementById(containerId);
            container.scrollBy({
                left: direction === 'left' ? -300 : 300,
                behavior: 'smooth'
            });
        }
    </script>

        
    </div>
</body>
</html>