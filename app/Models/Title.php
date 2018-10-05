<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Title extends Model
{

    protected $connection = 'mysql';
    protected $table = 'im_prefix_cd';
    protected $primaryKey = 'impfx_id';
    public $timestamps = false;

    public function changeConnection($conn)
    {
        $this->connection = $conn;
    }

}
