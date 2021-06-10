<?php

use App\Playlist;

    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Methods: DELETE");
    header("Access-Control-Allow-Headers: Origin,Accept, Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    header("HTTP/1.1 200 OK");

    require_once __DIR__."/../../config.php";
    require __DIR__."/../auth.php";

    $playlist = new Playlist($pdoconn);
    $json = array();

    if(isset($_REQUEST['id']) && !(empty($_REQUEST['id']))){

        $onlyPlaylist = $playlist->getById($decoded->data->id, $_REQUEST['id']);

        if(count($onlyPlaylist) > 0){

            $json['playlist']=$onlyPlaylist[0];

            echo json_encode($json);

        }else{

            http_response_code(404);

            $json['error']="playlist not found.";

            echo json_encode($json);
        }
        
    }else{
        $allPlaylists = $playlist->getAll($decoded->data->id);

        if(count($allPlaylists) > 0){

            $json['playlists']=$allPlaylists;

            $json['total']=count($allPlaylists);

            echo json_encode($json);

        }else{
            http_response_code(404);

            $json['error']="Playlist not found.";
            
            echo json_encode($json);
        }
    }

?>