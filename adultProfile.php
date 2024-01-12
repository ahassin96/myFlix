<?php
session_start();
require 'vendor/autoload.php';

use MongoDB\Client;

$mongoClient = new Client("mongodb://ec2-54-221-90-30.compute-1.amazonaws.com:27017");

$database = $mongoClient->admin;

$genres = ['horror', 'military', 'action'];

echo  $_SESSION['user_id'];
echo  $_SESSION['username'];
if (isset($_GET['selectedProfile'])) {

        
        $_SESSION['userProfile'] = $_GET['selectedProfile'];
        echo $_SESSION['userProfile'];
    }

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

    <script>
        function loadVideoDetails(videoId, userAccount, userProfile) {
            $.ajax({
                type: 'GET',
                url: 'http://3.90.74.38:5000/watch/' + videoId, 
                success: function(response) {
                    console.log('Video details:', response.video_details);

                    if (response.success) {
                        $('#videoTitle').text(response.video_details.title);
                        $('#videoDescription').text(response.video_details.description);

                        $('#watchVideo source').attr('src', response.video_details.url);
                        $('#watchVideo')[0].load(); 

                        $('#watchVideo').on('play', function() {
                            $.ajax({
                                type: 'POST',
                                url: 'log_watch.php',
                                data: {
                                    videoId: videoId,
                                    userId: userAccount,
                                    userProfile: userProfile
                                },
                                success: function(response) {
                                    console.log('Watch logged successfully');
                                },
                                error: function(error) {
                                    console.error('Error logging watch: ' + error.responseText);
                                }
                            });
                        });
                    } else {
                        console.error('Error fetching video details:', response.error);
                    }
                },
                error: function(error) {
                    console.error('Error fetching video details:', error.responseText);
                }
            });
        }
    </script>

    <?php
    try {
        foreach ($genres as $genre) {
            $videos = $database->movies->find(['genre' => $genre]);
            ?>

            <div class="video-container" id="<?php echo $genre; ?>-container">
                <h2><?php echo ucfirst($genre); ?></h2>

                <?php
                foreach ($videos as $video) {
                    ?>
                    <div class="video">
                        <p><?php echo $video['title']; ?></p>
                        <a href="http://3.90.74.38:5000/watch.php/<?php echo $video['_id']; ?>">Watch Details</a>

                        <video controls>
                            <source src="<?php echo $video['url']; ?>" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                        
                    </div>
                    <?php
                }
                ?>
            </div>

            <?php
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
    ?>

</body>
</html>