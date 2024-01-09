<?php
require 'vendor/autoload.php';

use MongoDB\Client;

$mongoClient = new Client("mongodb://ec2-44-221-241-112.compute-1.amazonaws.com:27017");
$database = $mongoClient->myflix;


$videoId = $_GET['id'];
$userAccount = $_SESSION['user_id'];
$Profile = $_SESSION['userProfile']


try {
    
    $videoDetails = $database->movies->findOne(['_id' => new MongoDB\BSON\ObjectId($videoId)]);

    if ($videoDetails) {
        ?>

        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
             <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
            <link rel="stylesheet" href="css/style.css">
            <title>Watch Video - MyFlix</title>
        </head>
        <body>
            <h1>Watch Video - MyFlix</h1>
            <h2><?php echo $videoDetails['title']; ?></h2>
            <p><?php echo $videoDetails['description']; ?></p>

            <video id="watchVideo" controls>
                <source src="<?php echo $videoDetails['url']; ?>" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <p>test</p>
            <script>
                
                $(document).ready(function() {
                    var videoId = "<?php echo $videoId; ?>";
                    var userId = "<?php echo $userAccount; ?>";
                    var userProfile = "<?php echo $Profile; ?>";

                    $('#watchVideo').on('play', function() {
                        $.ajax({
                            type: 'POST',
                            url: 'log_watch.php',
                            data: {
                                videoId: videoId,
                                userId: userId,
                                userProfile: userProfile
                            },
                            success: function(response) {
                                console.log('Watch logged successfully');
                            },
                            error: function(error) {
                                console.error('Error logging watch: ' + error);
                            }
                        });
                    });
                });
            </script>
        </body>
        </html>

        <?php
    } else {
        echo "Video not found.";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
