<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientData extends Model
{

    protected $connection = 'mysql';
    protected $table = 'im_patient_biodata';
    protected $primaryKey = 'impb_id';
    public $timestamps = false;

    public function changeConnection($conn)
    {
        $this->connection = $conn;
    }

}
