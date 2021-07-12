<?php
    namespace App;

    class Playlist{

        private $pdoconn;

        public function __construct($pdoconn) {
            $this->pdoconn = $pdoconn;
        }
        
        public function insert($name, $user_id, $song_ids=NULL){

            $sql = 'INSERT INTO `playlists` (
                name,
                user_id
            )
            VALUES (
                :name,
                :user_id
            )';
            
            $query = $this->pdoconn->prepare($sql);
            $query->bindValue(':name',$name);
            $query->bindValue(':user_id',$user_id);
            
            if(!isset($song_ids)){
                return ($query->execute());
            }

            $query->execute();

            $new_playlist_id = $this->pdoconn->lastInsertId();

            foreach ($song_ids as $song_id) {
                
                $sql = 'INSERT INTO `songs_playlists` (
                    playlist_id,
                    song_id
                )
                VALUES (
                    :playlist_id,
                    :song_id
                )';

                $query = $this->pdoconn->prepare($sql);
                $query->bindValue(':playlist_id',$new_playlist_id);
                $query->bindValue(':song_id',$song_id);

            }

            return ($query->execute());
        }
        
        public function addSongs($playlist_id, $song_ids=NULL){

            foreach ($song_ids as $song_id) {
                
                $sql = 'INSERT INTO `songs_playlists` (
                    playlist_id,
                    song_id
                )
                VALUES (
                    :playlist_id,
                    :song_id
                )';
                
                $query = $this->pdoconn->prepare($sql);
                $query->bindValue(':playlist_id',$playlist_id);
                $query->bindValue(':song_id',$song_id);
                $query->execute();

            }

            return true;
        }
        
        public function removeSongs($playlist_id, $song_ids){

            foreach ($song_ids as $song_id) {

                $sql = 'DELETE FROM `songs_playlists` 
                WHERE playlist_id=:playlist_id AND song_id=:song_id';
                
                $query = $this->pdoconn->prepare($sql);
                $query->bindValue(':playlist_id',$playlist_id);
                $query->bindValue(':song_id',$song_id);
                $query->execute();

            }

            return true;
        }

        public function getById($user_id, $playlist_id) {
            
            $sql = 'SELECT *
                    FROM  `playlists`
                    WHERE playlists.user_id=:user_id AND playlists.id=:playlist_id';

                    
            $query = $this->pdoconn->prepare($sql);
            $query->bindValue(':user_id',$user_id);
            $query->bindValue(':playlist_id',$playlist_id);
            $query->execute();

            return $query->fetchAll(\PDO::FETCH_ASSOC);
        }
        
        public function getBySongId($user_id, $song_id) {
            
            $sql = 'SELECT 
                        songs.id AS song_id, 
                        songs.name AS song_name,
                        songs.description AS song_description,
                        songs.length,
                        songs.thumbnail,
                        songs.artist_id,
                        songs.genre_id,
                        songs.mood_id,

                        artists.name AS artist_name,
                        artists.description AS artist_description,

                        genres.name AS genre_name,
                        genres.description AS genre_description,

                        moods.name AS mood_name,
                        moods.description AS mood_description
                    FROM `favorites`
                    LEFT JOIN `songs`
                        ON favorites.song_id = songs.id
                    LEFT JOIN `artists` 
                        ON songs.artist_id = artists.id
                    LEFT JOIN `genres` 
                        ON songs.genre_id = genres.id
                    LEFT JOIN `moods`
                        ON songs.mood_id = moods.id
                    WHERE favorites.user_id=:user_id and favorites.song_id=:song_id';

            $query = $this->pdoconn->prepare($sql);
            $query->bindValue(':user_id',$user_id);
            $query->bindValue(':song_id',$song_id);
            $query->execute();

            return $query->fetchAll(\PDO::FETCH_ASSOC);
        }
        
        public function getAll($user_id) {
            
            $sql = 'SELECT *
                    FROM  `playlists`
                    WHERE playlists.user_id=:user_id';

            $query = $this->pdoconn->prepare($sql);
            $query->bindValue(':user_id',$user_id);
            $query->execute();

            return $query->fetchAll(\PDO::FETCH_ASSOC);
        }
        
        public function getAllSongsByPlaylistId($user_id, $playlist_id) {
            
            $sql = 'SELECT 
                        songs.id AS song_id, 
                        songs.name AS song_name,
                        songs.description AS song_description,
                        songs.length,
                        songs.thumbnail,
                        songs.artist_id,
                        songs.genre_id,
                        songs.mood_id,

                        artists.name AS artist_name,
                        artists.description AS artist_description,

                        genres.name AS genre_name,
                        genres.description AS genre_description,

                        moods.name AS mood_name,
                        moods.description AS mood_description
                    FROM `songs_playlists`
                    LEFT JOIN `playlists`
                        ON songs_playlists.playlist_id = playlists.id
                    LEFT JOIN `songs`
                        ON songs_playlists.song_id = songs.id
                    LEFT JOIN `artists` 
                        ON songs.artist_id = artists.id
                    LEFT JOIN `genres` 
                        ON songs.genre_id = genres.id
                    LEFT JOIN `moods`
                        ON songs.mood_id = moods.id
                    WHERE playlists.user_id=:user_id AND playlists.id=:playlist_id';

            $query = $this->pdoconn->prepare($sql);
            $query->bindValue(':user_id',$user_id);
            $query->bindValue(':playlist_id',$playlist_id);
            $query->execute();

            return $query->fetchAll(\PDO::FETCH_ASSOC);
        }
        
        public function update($data){
            $sql = 'UPDATE `playlists`
                    SET 
                        name=:name
                    WHERE id=:id';

            $query = $this->pdoconn->prepare($sql);
            $query->execute([
                ':id'=>$data['id'],
                ':name'=>$data['name']
            ]);

            return $query->rowCount() > 0;
        }
        

        public function delete($playlist_id){

            $sql = 'DELETE FROM `playlists` 
                    WHERE id=:playlist_id';

            $query = $this->pdoconn->prepare($sql);

            $query->bindValue(':playlist_id', $playlist_id);

            $query->execute();

            return $query->rowCount() > 0;
        }
        
    }