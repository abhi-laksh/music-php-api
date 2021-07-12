<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Options,OPTIONS, Origin, Accept, Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("HTTP/1.1 200 OK");

use App\Playlist;


    require_once __DIR__."/../../config.php";
    require __DIR__."/../auth.php";

    $playlist = new Playlist($pdoconn);

    $data = json_decode(file_get_contents("php://input"));

    if(
        !(isset($data->songs))
        || empty($data->songs)
    ){

        $result = $playlist->insert($data->name, $decoded->data->id);
        
    }else{
        
        $result = $playlist->insert($data->name, $decoded->data->id,$data->songs);
        
    }

    
    if(($result)){

        $json = array();

        $json['msg']="New Playlist created!";
        
        echo json_encode($json);

    }


?>