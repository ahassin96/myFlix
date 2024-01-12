<?php
session_start();
require 'vendor/autoload.php';
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
        <h2><?php echo $videoDetails['title']; ?></h2>
        <p><?php echo $videoDetails['description']; ?></p>
    </div>

    <video id="watchVideo" controls>
        Your browser does not support the video tag.
    </video>

    <script>
    $(document).ready(function() {
        var videoId = "<?php echo $_GET['id']; ?>";

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
