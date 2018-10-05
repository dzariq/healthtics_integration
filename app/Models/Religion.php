<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Religion extends Model
{

    protected $connection = 'mysql';
    protected $table = 'im_religion_cd';
    protected $primaryKey = 'imr_id';
    public $timestamps = false;

    public function changeConnection($conn)
    {
        $this->connection = $conn;
    }

}
