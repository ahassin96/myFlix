<?php
require 'vendor/autoload.php';

use GraphAware\Neo4j\Client\ClientBuilder;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$neo4jConnection = [
    'host' => $_ENV['NEO4J_HOST'],
    'port' => $_ENV['NEO4J_PORT'],
    'username' => $_ENV['NEO4J_USERNAME'],
    'password' => $_ENV['NEO4J_PASSWORD'],
];

echo '<script>';
echo 'console.log(' . json_encode($neo4jConnection, JSON_PRETTY_PRINT) . ');';
echo '</script>';


$connectionUrl = sprintf(
    'bolt://%s:%s@%s:%s',
    $neo4jConnection['username'],
    $neo4jConnection['password'],
    $neo4jConnection['host'],
    $neo4jConnection['port']
);

$client = ClientBuilder::create()
    ->addConnection('default', $connectionUrl)
    ->setAutoFormatResponse(true)
    ->build();


$videoId = $_POST['videoId'];
$userId = $_POST['userId'];
$userProfile = $_POST['userProfile'];

try {
   
   $client->run("
        MERGE (u:User {_id: {userId}})
    ", ['userId' => $userId]);

    
    $client->run("
        MERGE (v:Video {_id: {videoId}})
    ", ['videoId' => $videoId]);

    $client->run("
        MATCH (u:User {_id: {userId}})
        MATCH (v:Video {_id: {videoId}})
        MERGE (u)-[:WATCHED {profile: {userProfile}}]->(v)
    ", [
        'userId' => $userId,
        'videoId' => $videoId,
        'userProfile' => $userProfile,
    ]);
    
    $client->run($query, $parameters);


    echo json_encode(['success' => true]);
} catch (Exception $e) {
    
    echo json_encode(['error' => 'Error logging watch: ' . $e->getMessage()]);
}