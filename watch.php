<?php
$videoUrl = $_GET['url'] ?? '';

if ($videoUrl) {
    echo '<video width="640" height="360" controls>';
    echo '<source src="' . $videoUrl . '" type="video/mp4">';
    echo 'Your browser does not support the video tag.';
    echo '</video>';
} else {
    echo 'Invalid video URL.';
}