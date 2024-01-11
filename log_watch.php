<?php
require 'vendor/autoload.php';

use GraphAware\Neo4j\Client\ClientBuilder;
use Dotenv\Dotenv;


$neo4jConnection = [
    'host' => $_ENV['NEO4J_HOST'],
    'port' => $_ENV['NEO4J_PORT'],
    'username' => $_ENV['NEO4J_USERNAME'],
    'password' => $_ENV['NEO4J_PASSWORD'],
];


$client = ClientBuilder::create()
    ->addConnection('default', $neo4jConnection['host'], $neo4jConnection['port'])
    ->setAuthentication($neo4jConnection['username'], $neo4jConnection['password'])
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