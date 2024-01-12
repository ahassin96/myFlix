<?php
session_start();
require 'vendor/autoload.php';

$videoId = isset($_GET['id']) ? $_GET['id'] : null;
$userAccount = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$Profile = isset($_SESSION['userProfile']) ? $_SESSION['userProfile'] : null;

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

       <div id="videoDetailsContainer">
            <?php
           
            if (isset($videoDetails['title'])) {
                echo "<h2>{$videoDetails['title']}</h2>";
            } else {
                echo "<h2>Video Title Not Available</h2>";
            }

            if (isset($videoDetails['description'])) {
                echo "<p>{$videoDetails['description']}</p>";
            } else {
                echo "<p>Video Description Not Available</p>";
            }
            ?>
        </div>

    <video id="watchVideo" controls>
        Your browser does not support the video tag.
    </video>

    <script>
    $(document).ready(function() {
            var videoId = "<?php echo $videoId; ?>";
            var userAccount = "<?php echo $userAccount; ?>";
            var userProfile = "<?php echo $Profile; ?>";

        $.ajax({
            type: 'GET',
            url: 'http://3.90.74.38:5000/watch.php/' + videoId,
            success: function(response) {
                console.log('Video details:', response.video_details);

                if (response.success) {
                    $('#videoDetailsContainer').html(`
                        <h2>${response.video_details.title}</h2>
                        <p>${response.video_details.description}</p>
                    `);

                    $('#watchVideo source').attr('src', response.video_details.url);

                    $('#watchVideo').on('play', function() {
                        $.ajax({
                            type: 'POST',
                            url: 'log_watch.php',
                            data: {
                                videoId: videoId,
                                userId: "<?php echo $_SESSION['user_id']; ?>",
                                userProfile: "<?php echo $_SESSION['userProfile']; ?>"
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
    });
</script>
</body>
</html>
