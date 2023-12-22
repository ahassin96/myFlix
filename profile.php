<?php

require 'vendor/autoload.php';

use MongoDB\Client;

$mongoClient = new Client("mongodb://ec2-44-221-241-112.compute-1.amazonaws.com:27017");

$database = $mongoClient->myflix;

$genres = ['horror', 'military', 'action'];


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel="stylesheet" href="css/style.css">
    <title>MyFlix Video Library</title>
</head>
<body>
    <h1>MyFlix Video Library</h1>

    <?php foreach ($genres as $genre) {
       
        $videos = $database->videos->find(['genre' => $genre]);

       
        ?>
        <div class="video-container" id="<?php echo $genre; ?>-container">
            <h2><?php echo ucfirst($genre); ?></h2>
        <?php

     
        foreach ($videos as $video) {
            
            ?>
            <div class="video">
                <video controls>
                    <source src="<?php echo $video['url']; ?>" type="video/mp4">
                    Your browser does not support the video tag.
                </video>
                <p><?php echo $video['title']; ?></p>
            </div>
            <?php
        }

        ?>
        </div>
        <?php
    }

    ?>
    </body>
    </html>