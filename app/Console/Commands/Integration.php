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
//        $today = date('j/n/Y h:i A');
        $today = date('j/n/Y');
        // print_r($today);die;
        $parentData = DB::table('eklinikal_all_data')->where('type', 'STAF')->where('date_change', '<', $today)->orderby('date_change', 'ASC')->limit(1)->get();
//        $parentData = DB::table('eklinikal_all_data')->where('date_change', '!=', '')->where('date_change','<',$today)->where('type', 'STAF')->orderby('date_change','ASC')->limit(100)->get();
//        print_r(($parentData));
//        die;
        //loop data
        foreach ($parentData as $patient)
        {
            DB::beginTransaction();
            $patientID = $patient->nric != '' ? $patient->nric : $patient->old_nric;


            //check in biodata healthics 
            $patientInHealthtics = \App\Models\PatientData::where('impb_no', $patientID)->get();
            if (!$patientInHealthtics)
            {
                $patientInHealthtics = new \App\Models\PatientData;
                $this->populateBiodata($patientInHealthtics, $patient, $patientID);
            }
            else
            {
                foreach ($patientInHealthtics as $localData)
                {
                    $this->populateBiodata($localData, $patient,$patientID);
                }
            }

            DB::commit();
        }
    }

    public function populateBiodata($patientInHealthtics, $patient,$patientID)
    {
        $editedDate = date('Y-m-d');
        $editedTime = date('H:i:s');

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
        $patientInHealthtics->imr_id = $this->religionMap($patient->religion);
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
        $patientInHealthtics->save();

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
        $patientAddrInHealthtics->save();
    }

    public function religionMap($name)
    {
        if ($name == 'Islam')
        {
            return 1;
        }
        else if ($name == 'Hindu')
        {
            return 2;
        }
        else if ($name == 'Kristian')
        {
            return 3;
        }
        else if ($name == 'Buddha')
        {
            return 4;
        }
        else if ($name == 'Tiada Agama')
        {
            return 5;
        }
        else if ($name == 'Lain Agama')
        {
            return 6;
        }
        else if ($name == 'Maklumat Tiada')
        {
            return 7;
        }
        else if ($name == 'Sikhism')
        {
            return 8;
        }
        else if ($name == 'Tao')
        {
            return 9;
        }
        else if ($name == 'Konfusianisme')
        {
            return 10;
        }
        else if ($name == 'Bahai')
        {
            return 11;
        }
        else
        {
            return 0;
        }
    }

}
