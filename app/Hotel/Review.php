<?php

/**
 * The Review class handles user reviews, including retrieval, insertion, and removal of reviews in the database.
 */

namespace Hotel;

use Hotel\BaseService;

class Review extends BaseService
{
    public function getListByUserId($userId) {
        // Prepare parameters
        $parameters = [
            ':user_id' => $userId,
        ];

        return $this->fetchAll('SELECT review.*, room.name, room.city, room.area, room.photo_url
            FROM review 
            INNER JOIN room On review.room_id = room.room_id
            WHERE user_id = :user_id', $parameters);
    }

    public function insertReview($roomId, $userId, $rate, $comment)
    {
        // Start trasaction
        $this->getPdo()->beginTransaction();

        // Insert review 
        $parameters = [
            ':room_id' => $roomId,
            ':user_id' => $userId,
            ':rate' => $rate,
            ':comment' => $comment,
        ];

        $this->execute('INSERT INTO review (room_id, user_id, rate, comment) VALUES (:room_id, :user_id, :rate, :comment)', 
            $parameters);
        
        // Update room average reviews
        $this->updateRoomAverage($roomId);

        // Commit transaction
        return $this->getPdo()->commit();
    }

    public function removeReview($roomId, $reviewId)
    {
        // Start trasaction
        $this->getPdo()->beginTransaction();

        // Prepare parameters
        $parameters = [
            ':review_id' => $reviewId,
        ];

        $this->execute('DELETE FROM review WHERE review_id = :review_id', $parameters);

        // Update room average reviews
        $this->updateRoomAverage($roomId);

        // Commit transaction
        return $this->getPdo()->commit();
    }

    public function updateRoomAverage($roomId)
    {   
        // Prepare parameters
        $parameters = [
            ':room_id' => $roomId,
        ];

        $roomAverage = $this->fetch('SELECT AVG(rate) AS avg_reviews, COUNT(*) AS count FROM review WHERE room_id = :room_id', $parameters);

        // Prepare parameters
        $parameters = [
            ':room_id' => $roomId,
            ':avg_reviews' => $roomAverage['avg_reviews'],
            ':count_reviews' => $roomAverage['count'],
        ];

        $this->execute('UPDATE room SET avg_reviews = :avg_reviews, count_reviews = :count_reviews WHERE room_id = :room_id', $parameters);
    }

    public function getReviewsByRoom($roomId)
    {   
        // Prepare parameters
        $parameters = [
            ':room_id' => $roomId,
        ];

        return $this->fetchAll('SELECT review.*, user.name AS user_name 
            FROM review 
            INNER JOIN user ON review.user_id = user.user_id 
            WHERE room_id = :room_id
            ORDER BY created_time ASC', $parameters);
    }
}