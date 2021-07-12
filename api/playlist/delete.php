<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Allow-Headers: Origin,Accept, Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("HTTP/1.1 200 OK");

use App\Playlist;

    require_once __DIR__."/../../config.php";
    require __DIR__."/../auth.php";

    $playlist = new Playlist($pdoconn);

    $data = json_decode(file_get_contents("php://input"));

    if(
        !(
            (isset($data->id) && !empty($data->id))
        )
    ){
        
        http_response_code(400);

        echo json_encode(array(
            "error"=>"Delete unsuccessful! Missing id",
        ));

        exit();
    }

    if(($playlist->delete($data-> id))){
        echo json_encode(array(
            "msg"=>"Playlist deleted!"
        ));
    }else{
        http_response_code(400);
        echo json_encode(array(
            "error"=>"Unable to delete playlist."
        ));
    }

?>