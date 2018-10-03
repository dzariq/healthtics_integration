<<<<<<< HEAD
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;
use DB;

class Integration extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'integration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $test = DB::table('eklinikal_all_data')->limit(1)->get();
        print_r($test);
        die;

        $patientData = new \App\Models\PatientData;
        $patientData->changeConnection('mysql');
        $data = $patientData->limit(10)->get();
        print_r($data);
    }
}
=======
<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;
use DB;

class Integration extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'integration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $parentData = DB::table('eklinikal_all_data')->where('date_change', '!=', '')->where('type', 'STAF')->limit(100)->get();
        print_r(count($parentData));
        die;

        //loop data
        foreach ($parentData as $patient)
        {
            DB::beginTransaction();

            $patientID = $patient->nric != '' ? $patient->nric : $patient->old_nric;
            $editedDate = '';
            $editedTime = '';
            //check in biodata healthics 
            $patientInHealthtics = \App\Models\PatientData::where('impb_no', $patientID)->first();
            if (!$patientInHealthtics)
            {
                $patientInHealthtics = new \App\Models\PatientData;
            }
            $patientInHealthtics->impb_card_no = $patient->staf_no;
            $patientInHealthtics->impfx_id = $patient->title;
            $patientInHealthtics->impb_name = $patient->name;
            $patientInHealthtics->imtn_id = 1;
            $patientInHealthtics->impb_no = $patientID;
            $patientInHealthtics->img_id = $patient->gender;
            $patientInHealthtics->impb_birthday = $patient->dob;
            $patientInHealthtics->imms_id = 2;
            $patientInHealthtics->imrsd_id = 0;
            $patientInHealthtics->imls_id = 0;
            $patientInHealthtics->imnt_id = 0;
            $patientInHealthtics->imr_id = $patient->religion;
            $patientInHealthtics->imrc_id = $patient->race;
            $patientInHealthtics->imna_id = $patient->nationality;
            $patientInHealthtics->impb_occupation = $patient->occupation;
            $patientInHealthtics->impb_employer = 0;
            $patientInHealthtics->impb_status = $patient->status;
            $patientInHealthtics->imc_id = 3; //USIM
            $patientInHealthtics->imclient_id = 1; 
            $patientInHealthtics->impb_edited_by = 1;
            $patientInHealthtics->impb_edited_date = $editedDate;
            $patientInHealthtics->impb_edited_time = $editedTime; 
            $patientInHealthtics->point_id = 0; 
            // $patientInHealthtics->save();

            $patientAddrInHealthtics = \App\Models\PatientAddress::where('impb_id', $patientInHealthtics->id)->first();
            if (!$patientAddrInHealthtics)
            {
                $patientAddrInHealthtics = new \App\Models\PatientAddress;
            }

            $patientAddrInHealthtics->impaddr_add1 = $patient->home_ad1; 
            $patientAddrInHealthtics->impaddr_add2 = $patient->home_ad2; 
            $patientAddrInHealthtics->impaddr_state = $patient->home_country; 
            $patientAddrInHealthtics->impaddr_poscode = $patient->home_postcode; 
            $patientAddrInHealthtics->impaddr_tel = $patient->home_tel; 
            $patientAddrInHealthtics->impaddr_officeno = $patient->office_tel; 
            $patientAddrInHealthtics->impaddr_hp = $patient->mobile_tel; 
            $patientAddrInHealthtics->impaddr_fax = $patient->fax_no; 
            $patientAddrInHealthtics->impaddr_email = $patient->email_add; 
            $patientAddrInHealthtics->impaddr_hp = $patient->fax_no; 
            $patientAddrInHealthtics->imclient_id = 1; 
            $patientAddrInHealthtics->imhostel_name = $patient->hostel; 
            $patientAddrInHealthtics->imhostel_room = $patient->room_no; 
            $patientAddrInHealthtics->impaddr_edited_date = $editedDate; 
            $patientAddrInHealthtics->impaddr_edited_time = $editedTime; 
            //  $patientAddrInHealthtics->save();

            DB::commit();
        }
    }

}
>>>>>>> 8e1fdc633dd71091a9bf8fbc83f98353f839acb1
