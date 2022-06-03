<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: multipart/form-data; charset=UTF-8");
header("Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With");

include_once '../../config/Database.php';
include_once '../../model/Game.php';
include_once '../../middleware/AuthMiddleware.php';

// GetAllHeaders
$allHeaders = getallheaders();

// Instantiate DB & Connect
$database = new Database();
$db = $database->connect();

// instantiate game object
$game = new Game($db);

// instantiate authorization
$auth = new Auth($db, $allHeaders);

// Get raw game data
$data = $_POST;
if (!empty($_FILES['image'])) {
    $fileName  =  $_FILES['image']['name'];
    $tempPath  =  $_FILES['image']['tmp_name'];
    $fileSize  =  $_FILES['image']['size'];

    $temp = explode(".", $_FILES["image"]["name"]);
    $newfilename = round(microtime(true)) . '.' . end($temp);

    $upload_path = '../../upload/'; // set upload folder path 

    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION)); // get image extension

    // valid image extensions
    $valid_extensions = array('jpeg', 'jpg', 'png', 'gif');


    // check file size '5MB'
    if ($fileSize < 5000000) {
        move_uploaded_file($tempPath, $upload_path . $newfilename); // move file from system temporary path to our upload folder path 
        $game->image = 'upload/' . $newfilename;
    } else {
        $errorMSG = json_encode(array("message" => "Sorry, your file is too large, please upload 5 MB size", "status" => false));
        echo $errorMSG;
    }
}


// cek if user have a token
if ($auth->isValid()['success'] === 1) {
    if (
        isset($data['title']) && isset($data['link']) &&
        isset($data['video_link']) && isset($data['genre_id']) &&
        isset($data['user_id'])
    ) {
        $game->title = $data['title'];
        $game->link = $data['link'];
        $game->video_link = $data['video_link'];
        $game->genre_id = $data['genre_id'];
        $game->user_id = $data['user_id'];

        // Create game
        if ($game->create()) {
            echo json_encode(
                array('success' => 1, 'status' => '201', 'message' => 'game created')
            );
        } else {
            echo json_encode(
                array('success' => 0, 'status' => '500', 'message' => 'game not created')
            );
        }
    } else {
        echo json_encode(
            array('success' => 0, 'status' => '403', 'message' => 'field is required')
        );
    }
} else {
    echo json_encode($auth->isValid());
}
