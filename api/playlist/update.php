<?php

use App\Playlist;

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("HTTP/1.1 200 OK");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    require_once __DIR__."/../../config.php";
    require __DIR__."/../auth.php";

    $data = json_decode(file_get_contents("php://input"));

    if(
        !(
            (isset($data->name) && !empty($data->name))
            && (isset($data->id) && !empty($data->id))
        )
    ){
        http_response_code(400);
        echo json_encode(array(
            "error"=>"Please fill all details",
        ));
        exit();
    }

    $playlist = new Playlist($pdoconn);

    if(($playlist->update(array(
        "id" => $data->id,
        "name" => $data->name,
    )))){
        
        echo json_encode(array(
            "msg"=>"Playlist updated!"
        ));

    }else{
        
        http_response_code(400);

        echo json_encode(array(
            "error"=>"Unable to update Playlist."
        ));

    }

?>