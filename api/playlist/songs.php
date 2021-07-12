<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Origin,Accept, Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("HTTP/1.1 200 OK");

    use App\Playlist;

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