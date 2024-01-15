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
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <title>MyFlix Video Library</title>
</head>
<body>
    <h1>MyFlix Video Library</h1>


    <?php
    try {
        $flask_url = "http://3.90.74.38:9092/recommendations/" . $_SESSION['user_id'];
        $json_data = file_get_contents($flask_url);
        $recommendations = json_decode($json_data, true)['recommendations'];

        if (!empty($recommendations)) {
            $firstRecommendation = reset($recommendations);
            $video_id = $firstRecommendation['video_id'];
            $tags = implode(', ', $firstRecommendation['tags']);
            ?>

            <div class="video-container" id="recommendations-container">
                <h2>Recommendation</h2>
                <div class="video">
                    <p>Recommendation: <?php echo $video_id; ?></p>
                    <p>Tags: <?php echo $tags; ?></p>

                    <video controls>
                        <source src="http://3.90.74.38:9090/movies/<?php echo $video_id; ?>" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                </div>
            </div>
            <?php
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }


    try {
        foreach ($genres as $genre) {
            $flask_url = "http://3.90.74.38:9092/recommendations/" . $_SESSION['user_id'];
            $json_data = file_get_contents($flask_url);
            $recommendations = json_decode($json_data, true)['recommendations'];
            ?>

            <div class="video-container" id="recommendations-container">
                <h2>Recommendations</h2>
                <?php
                foreach ($recommendations as $recommendation) {
                    ?>
                    <div class="video">
                        <p>Recommendation: <?php echo $recommendation['video_id']; ?></p>
                        <p>Tags: <?php echo implode(', ', $recommendation['tags']); ?></p>
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


    try {



        foreach ($genres as $genre) {
            $flask_url = "http://3.90.74.38:9090/movies"; 
            $json_data = file_get_contents($flask_url);
            $videos = json_decode($json_data, true)[$genre];
            ?>

            <div class="video-container" id="<?php echo $genre; ?>-container">
                <h2><?php echo ucfirst($genre); ?></h2>

                <?php
                foreach ($videos as $video) {
                    ?>
                    <div class="video">
                        <p><?php echo $video['title']; ?></p>
                        <a href="watch.php?id=<?php echo $video['_id']; ?>">Watch Details</a>

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