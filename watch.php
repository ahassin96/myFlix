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
        <h2 id="videoTitle">Video Title Not Available</h2>
        <p id="videoDescription">Video Description Not Available</p>
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
            url: 'http://3.90.74.38:5000/watch/' + videoId, 
            success: function(response) {
                console.log('Video details:', response.video_details);

                if (response.video_details) {
                    $('#videoTitle').text(response.video_details.title);
                    $('#videoDescription').text(response
