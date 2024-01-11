<?php
session_start();
require 'vendor/autoload.php';

use GraphAware\Neo4j\Client\ClientBuilder;
use MongoDB\Client;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$neo4jConnection = [
    'host' => $_ENV['NEO4J_HOST'],
    'port' => $_ENV['NEO4J_PORT'],
    'username' => $_ENV['NEO4J_USERNAME'],
    'password' => $_ENV['NEO4J_PASSWORD'],
];

$connectionUrl = sprintf(
    'bolt://%s:%s@%s:%s',
    $neo4jConnection['username'],
    $neo4jConnection['password'],
    $neo4jConnection['host'],
    $neo4jConnection['port']
);

$clientNeo4j = ClientBuilder::create()
    ->addConnection('default', $connectionUrl, null, null, null, null, null, null)
    ->build();

$mongoClient = new Client("mongodb://ec2-54-221-90-30.compute-1.amazonaws.com:27017");
$database = $mongoClient->admin;

$videoId = $_GET['id'];
$userAccount = $_SESSION['user_id'];
$Profile = $_SESSION['userProfile'];

try {
   
    $clientNeo4j->run("MERGE (u:User {_id: {userId}})", ['userId' => $userAccount]);
    $clientNeo4j->run("MERGE (v:Video {_id: {videoId}})", ['videoId' => $videoId]);

    $clientNeo4j->run(
        "MATCH (u:User {_id: {userId}})
        MATCH (v:Video {_id: {videoId}})
        MERGE (u)-[:WATCHED {profile: {userProfile}}]->(v)",
        [
            'userId' => $userAccount,
            'videoId' => $videoId,
            'userProfile' => $Profile,
        ]
    );

   
    $videoDetails = $database->movies->findOne(['_id' => new MongoDB\BSON\ObjectId($videoId)]);

    if ($videoDetails) {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            
        </head>
        <body>
    
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
                                console.error('Error logging watch: ' + error.responseText);
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
