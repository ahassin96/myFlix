<!DOCTYPE html>
<html lang="en">
<head>
    
</head>
<body>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script>
        function logWatchHistory(videoId, userAccount, userProfile) {
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
        }

        $(document).ready(function() {
            
            $('a.watch-details').click(function(event) {
                event.preventDefault(); 

                var videoId = $(this).data('video-id');
                var userAccount = '<?php echo $_SESSION["user_id"]; ?>';
                var userProfile = '<?php echo $_SESSION["userProfile"]; ?>';

                logWatchHistory(videoId, userAccount, userProfile);

                window.location.href = 'http://3.90.74.38:5000/watch.php/' + videoId;
            });
        });
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
                        <a href="#" class="watch-details" data-video-id="<?php echo $video['_id']; ?>">Watch Details</a>

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
