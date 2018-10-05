<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{

    protected $connection = 'mysql';
    protected $table = 'im_country_cd';
    protected $primaryKey = 'imct_id';
    public $timestamps = false;

    public function changeConnection($conn)
    {
        $this->connection = $conn;
    }

}
