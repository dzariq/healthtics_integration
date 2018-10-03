<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientAddress extends Model
{

    protected $connection = 'mysql';
    protected $table = 'im_patient_addr';
    protected $primaryKey = 'impaddr_id';
    public $timestamps = false;

    public function changeConnection($conn)
    {
        $this->connection = $conn;
    }

}
