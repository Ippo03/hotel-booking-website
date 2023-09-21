<?php

/**
 * The RoomType class provides functionality to retrieve all room types available.
 */

namespace Hotel;

use PDO;
use DateTime;
use Hotel\BaseService;

class RoomType extends BaseService
{
    public function getAllTypes()
    {   
        return  $this->fetchAll('SELECT * FROM room_type');
    }
}