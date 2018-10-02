<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientData extends Model {

    protected $connection = 'mysql';
    protected $table = 'im_patient_biodata';

    public function changeConnection($conn) {
        $this->connection = $conn;
    }

}
