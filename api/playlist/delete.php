<?php

use App\Playlist;

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("HTTP/1.1 200 OK");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    require_once __DIR__."/../../config.php";
    require __DIR__."/../auth.php";

    $playlist = new Playlist($pdoconn);

    $data = json_decode(file_get_contents("php://input"));

    if(($playlist->delete($decoded->data->id))){
        echo json_encode(array(
            "msg"=>"Artist deleted!"
        ));
    }else{
        http_response_code(400);
        echo json_encode(array(
            "error"=>"Unable to delete artist."
        ));
    }

?>