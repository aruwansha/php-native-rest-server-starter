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

$game->page = isset($_GET['page']) ? $_GET['page'] : die();

// Blog game query
$result = $game->read();
// Call pagination
$pagination = $game->pagination();
//Get row count
$num = $result->rowCount();

// Check if any games
if ($num > 0) {
    // game array
    $games_arr = array();
    $games_arr['success'] = 1;
    $games_arr['status'] = 200;
    $games_arr['data'] = array();
    $games_arr['page'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $game_item = array(
            'id' => $id,
            'title' => $title,
            'author' => $username,
            'genre_id' => $genre_id,
            'genre_name' => $genre_name,
            'created_at' => $created_at
        );

        // Push to "data"
        array_push($games_arr['data'], $game_item);
    }

    $pagination_item = array(
        'current_page' => $pagination['current_page'],
        'previous_page' => $pagination['previous_page'],
        'next_page' => $pagination['next_page'],
        'total_page' => $pagination['total_page'],
    );

    // Push to "page"
    array_push($games_arr['page'], $pagination_item);
    // Turn to JSON & Output
    echo json_encode($games_arr);
} else {
    // No game
    echo json_encode(
        array('success' => 0, 'status' => '200', 'message' => 'No game found')
    );
}
