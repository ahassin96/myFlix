<?php


session_start();
require 'vendor/autoload.php';

$videoId = isset($_GET['id']) ? $_GET['id'] : null;
echo "video id is " . $videoId;
$userAccount = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
$Profile = isset($_SESSION['userProfile']) ? $_SESSION['userProfile'] : null;

$apiUrl = 'http://3.90.74.38:5000/watch/' . $videoId;
$videoDetailsJson = file_get_contents($apiUrl);
$videoDetails = json_decode($videoDetailsJson, true);

var_dump($videoDetails); 

$videoUrl = isset($videoDetails['url']) ? $videoDetails['url'] : '';
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
        <h2 id="videoTitle"><?php echo isset($videoDetails['title']) ? $videoDetails['title'] : 'Video Title Not Available'; ?></h2>
        <p id="videoDescription"><?php echo isset($videoDetails['description']) ? $videoDetails['description'] : 'Video Description Not Available'; ?></p>
    </div>

    <video id="watchVideo" controls>
        <source src="<?php echo isset($videoDetails['url']) ? $videoDetails['url'] : ''; ?>" type="video/mp4">
        Your browser does not support the video tag.
    </video>

</body>
</html>
