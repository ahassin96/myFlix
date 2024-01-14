<?php
require_once "connect.php";
$conn = new DbConnect();
$pdo = $conn->connect();
session_start();

echo  $_SESSION['user_id'];
echo  $_SESSION['username'];
echo $_SESSION['userProfile'];
  



require 'vendor/autoload.php';

$videoId = isset($_GET['id']) ? $_GET['id'] : null;

$apiUrl = 'http://3.90.74.38:5000/watch/' . $videoId;
$response = file_get_contents($apiUrl);

if ($response !== false) {
    $videoDetails = json_decode($response, true);

    if (isset($videoDetails['video_details'])) {
        $videoTitle = isset($videoDetails['video_details']['title']) ? $videoDetails['video_details']['title'] : 'Video Title Not Available';
        $videoDescription = isset($videoDetails['video_details']['description']) ? $videoDetails['video_details']['description'] : 'Video Description Not Available';
        $videoUrl = isset($videoDetails['video_details']['url']) ? $videoDetails['video_details']['url'] : '';

    } else {
        echo "Error: Video details not found.";
    }
} else {
    echo "Error: Unable to fetch video details.";
}
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
    <h2 id="videoTitle"><?php echo $videoTitle; ?></h2>
    <p id="videoDescription"><?php echo $videoDescription; ?></p>
</div>

<video id="watchVideo" controls>
    <source src="<?php echo $videoUrl; ?>" type="video/mp4">
    Your browser does not support the video tag.
</video>

</body>
</html>
