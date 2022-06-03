<?php
// Headers
header('Access-Control-Allow-Origin: ');
header('Content-Type: applictaion/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../model/Genre.php';
include_once '../../config/Database.php';
include_once '../../middleware/AuthMiddleware.php';

// GetAllHeaders
$allHeaders = getallheaders();

// Instantiate DB & Connect
$database = new Database();
$db = $database->connect();

// instantiate blog genre object
$genre = new Genre($db);

// instantiate authorization
$auth = new Auth($db, $allHeaders);

// Get input data
$data = json_decode(file_get_contents("php://input"));

$genre->name = $data->name;

// cek if user have a token
if ($auth->isValid()['success'] === 1) {
    // Create genre
    if ($genre->create()) {
        echo json_encode(array('success' => 1, 'status'=> '200', 'message' => 'genre created'));
    } else {
        echo json_encode(array('success' => 1, 'status'=> '500', 'message' => 'genre not created'));
    }
} else {
    echo json_encode($auth->isValid());
}
