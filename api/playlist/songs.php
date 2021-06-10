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

    if(
        !(isset($_REQUEST['id']))
        || empty($_REQUEST['id'])
    ){
        http_response_code(400);
        echo json_encode(array(
            "error"=>"Playlist id is expected!"
        ));
        exit();
    }
    
    $songs = $playlist->getAllSongsByPlaylistId($decoded->data->id, $_REQUEST['id']);
    
    if(count($songs) > 0){

        $json['songs']=$songs;

        $json['total']=count($songs);

        echo json_encode($json);

    }else{
        http_response_code(404);

        $json['error']="songs not found.";
        
        echo json_encode($json);
    }

?>