<?php
// Headers
header('Access-Control-Allow-Origin: ');
header('Content-Type: applictaion/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../model/Game.php';
include_once '../../middleware/AuthMiddleware.php';

// GetAllHeaders
$allHeaders = getallheaders();

// Instantiate DB & Connect
$database = new Database();
$db = $database->connect();

// instantiate blog game object
$game = new Game($db);

// instantiate authorization
$auth = new Auth($db, $allHeaders);

// Get raw game data
$data = json_decode(file_get_contents("php://input"));

// Set ID
$game->id = $data->id;

// cek if user have a token
if ($auth->isValid()['success'] === 1) {
    // Create game
    if ($game->delete()) {
        echo json_encode(
            array('success' => 1, 'status' => '200', 'message' => 'game has been deleted')
        );
    } else {
        echo json_encode(
            array('success' => 0, 'status' => '500', 'message' => 'failed to delete game')
        );
    }
} else{
    echo json_encode($auth->isValid());
}
