<?php

/**
 * The Room class provides methods for retrieving room information, including room details,
 * lists of rooms, filtered rooms by various criteria, and room amenities.
 */

namespace Hotel;

use PDO;
use DateTime;
use Hotel\BaseService;

class Room extends BaseService
{
    public function get($roomId) {
        // Prepare parameters
        $parameters = [
            ':room_id' => $roomId
        ];

        return $this->fetch('SELECT * FROM room WHERE room_id = :room_id', $parameters);
    }

    public function getRoomsList()
    {
        return $this->fetchAll('SELECT * FROM room');
    }

    public function getRoomsByPrice()
    {
        return $this->fetchAll('SELECT * FROM room ORDER BY price');
    }

    public function getRoomsByRating()
    {
        return $this->fetchAll('SELECT * FROM room ORDER BY avg_reviews DESC');
    }

    public function getCities()
    {   
        // Get all cities
        $cities = [];
        try {
            $rows = $this->fetchAll('SELECT DISTINCT city FROM room');
            foreach ($rows as $row) {
                $cities[] = $row['city'];
            }
        } catch (\Exception $ex) {
            // Log error
        }

        return $cities;
    }

    public function search($checkInDate, $checkOutDate, $city = '', $typeId = '', $price = '')
    {
        // Prepare parameters
        $parameters = [
            ':check_in_date' => $checkInDate,
            ':check_out_date' => $checkOutDate
        ];

        if (!empty($city)) {
            $parameters[':city'] = $city;
        }
        if (!empty($typeId)) {
            $parameters[':type_id'] = $typeId;
        }
        if (!empty($price)) {
            $parameters[':price'] = $price;
        }
        
        // Build query
        $sql = 'SELECT * FROM room WHERE ';
        if (!empty($city)) {
            $sql .= 'city = :city AND ';
        }
        if (!empty($typeId)) {
            $sql .= 'type_id = :type_id AND ';
        }
        if (!empty($price)) {
            $sql .= 'price <= :price AND ';
        }

        $sql .= 'room_id NOT IN (
                SELECT room_id
                FROM booking
                WHERE check_in_date <= :check_in_date AND check_out_date >= :check_out_date
        )';
        
        // Get results
        return $this->fetchAll($sql, $parameters);
    }

    public function filterAmenities($amenities)
    {
        $parameters = [];

        foreach ($amenities as $key => $value) {
            if ($value == 1) {
                $parameters[':' . $key] = $value;
            }
        }

        $sql = 'SELECT * FROM room WHERE ';
        foreach ($amenities as $key => $value) {
            if ($value == 1) {
                $sql .= $key . ' = :' . $key . ' AND ';
            }
        }
        $sql .= '1 = 1';

        return $this->fetchAll($sql, $parameters);
    }
}