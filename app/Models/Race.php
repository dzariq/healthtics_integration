<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Race extends Model
{

    protected $connection = 'mysql';
    protected $table = 'im_race_cd';
    protected $primaryKey = 'imrc_id';
    public $timestamps = false;

    public function changeConnection($conn)
    {
        $this->connection = $conn;
    }

}
