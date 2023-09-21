<?php

/**
 * The Favorite class handles user favorites, including listing favorite rooms, checking if a room is a favorite,
 * adding a room to favorites, and removing a room from favorites.
 */

namespace Hotel;

use Hotel\BaseService;

class Favorite extends BaseService
{
    public function getListByUserId($userId) {
        // Prepare parameters   
        $parameters = [
            ':user_id' => $userId,
        ];

        return $this->fetchAll('SELECT favorite.*, room.*
            FROM favorite 
            INNER JOIN room On favorite.room_id = room.room_id
            WHERE user_id = :user_id', $parameters);
    }
    
    public function isFavorite($roomId, $userId)
    {   
        // Prepare parameters
        $parameters = [
            ':room_id' => $roomId,
            ':user_id' => $userId,
        ];

        $favorite = $this->fetch('SELECT * FROM favorite WHERE room_id = :room_id AND user_id = :user_id', 
            $parameters);
        
        return !empty($favorite);
    }

    public function addFavorite($roomId, $userId)
    {
        // Prepare parameters
        $parameters = [
            ':room_id' => $roomId,
            ':user_id' => $userId,
        ];
            
        $rows = $this->execute('INSERT IGNORE INTO favorite (room_id, user_id) VALUES (:room_id, :user_id)', 
            $parameters);

        return $rows == 1;
    }

    public function removeFavorite($roomId, $userId)
    {
        // Prepare parameters
        $parameters = [
            ':room_id' => $roomId,
            ':user_id' => $userId,
        ];
        $rows = $this->execute('DELETE FROM favorite WHERE room_id = :room_id AND user_id = :user_id', 
            $parameters);

        return $rows == 1;
    }
}
