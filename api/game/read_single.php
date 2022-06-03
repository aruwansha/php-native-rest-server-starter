<?php
// Headers
header('Access-Control-Allow-Origin: ');
header('Content-Type: applictaion/json');

include_once '../../config/Database.php';
include_once '../../model/Game.php';

// Instantiate DB & Connect
$database = new Database();
$db = $database->connect();

// instantiate blog game object
$game = new Game($db);

// Get ID
$game->id = isset($_GET['id']) ? $_GET['id'] : die();

// Get game
$game->read_single();

$game_arr = array();

// Create array
$game_arr['success'] = 1;
$games_arr['status'] = 200;
$game_arr['data'] = array(
    'id' => $game->id,
    'title' => $game->title,
    'image' => $game->image,
    'link' => $game->link,
    'video_link' => $game->video_link,
    'author' => $game->author,
    'user_id' => $game->user_id,
    'genre_id' => $game->genre_id,
    'genre_name' => $game->genre_name,
    'created_at' => $game->created_at
);

// Make JSON
echo json_encode($game_arr);
