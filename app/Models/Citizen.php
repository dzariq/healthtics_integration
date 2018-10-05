<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Citizen extends Model
{

    protected $connection = 'mysql';
    protected $table = 'im_citizen_cd';
    protected $primaryKey = 'imctz_id';
    public $timestamps = false;

    public function changeConnection($conn)
    {
        $this->connection = $conn;
    }

}
