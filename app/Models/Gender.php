<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gender extends Model
{

    protected $connection = 'mysql';
    protected $table = 'im_gender_cd';
    protected $primaryKey = 'img_id';
    public $timestamps = false;

    public function changeConnection($conn)
    {
        $this->connection = $conn;
    }

}
