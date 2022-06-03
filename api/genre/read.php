<?php
// Headers
header('Access-Control-Allow-Origin: ');
header('Content-Type: applictaion/json');

include_once '../../config/Database.php';
include_once '../../model/Genre.php';

// Instantiate DB & Connect
$database = new Database();
$db = $database->connect();

// instantiate blog genre object
$genre = new Genre($db);

// Blog genre query
$result = $genre->read();

//Get row count
$num = $result->rowCount();

// Check if any genre
if ($num > 0) {
    // genre array
    $genres_arr = array();
    $genres_arr['success'] = 1;
    $genres_arr['status'] = 200;
    $genres_arr['data'] = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $genres_item = array(
            'id' => $id,
            'name' => $name,
            'total_post' => $count
        );

        // Push to "data"
        array_push($genres_arr['data'], $genres_item);
    }

    // Turn to JSON & Output
    echo json_encode($genres_arr);
} else {
    // No Post
    echo json_encode(
        array('success' => 0, 'status' => '200', 'message' => 'No genre found')
    );
}
