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
        $todayStart = date('d/m/Y');
        $todayStart = $todayStart . ' 00:00:00';
        $todayEnd = date('d/m/Y');
        $todayEnd = $todayEnd . ' 23:59:59';
        $yesterdayStart = date('d/m/Y', strtotime("-1 days"));
        $yesterdayStart = $yesterdayStart . ' 00:00:00';
        $yesterdayEnd = date('d/m/Y', strtotime("-1 days"));
        $yesterdayEnd = $yesterdayEnd . ' 23:59:59';
echo $todayStart;die;
        // print_r($today);die;
        $parentData = DB::table('eklinikal_all_data')->where('date_change', '>=', $todayStart)->where('date_change', '<=', $todayEnd)->orderby('date_change', 'ASC')->get();
//        $parentData = DB::table('eklinikal_all_data')->where('date_change', '!=', '')->where('date_change','<',$today)->where('type', 'STAF')->orderby('date_change','ASC')->limit(100)->get();
        print_r(($parentData));
        die;
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
                    $this->populateBiodata($localData, $patient, $patientID);
                }
            }

            DB::commit();
        }
    }

    public function populateBiodata($patientInHealthtics, $patient, $patientID)
    {
        $editedDate = date('Y-m-d');
        $editedTime = date('H:i:s');

        $patientInHealthtics->impb_card_no = $patient->staf_no;
        $patientInHealthtics->impfx_id = $this->titleMap($patient->title);
        $patientInHealthtics->impb_name = $patient->name;
        $patientInHealthtics->imtn_id = 1;
        $patientInHealthtics->impb_no = $patientID;
        $patientInHealthtics->img_id = $this->genderMap($patient->gender);
        $patientInHealthtics->impb_birthday = $patient->dob;
        $patientInHealthtics->imms_id = 2;
        $patientInHealthtics->imrsd_id = 0;
        $patientInHealthtics->imls_id = 0;
        $patientInHealthtics->imnt_id = 0;
        $patientInHealthtics->imr_id = $this->religionMap($patient->religion);
        $patientInHealthtics->imrc_id = $this->raceMap($patient->race);
        $patientInHealthtics->imna_id = $this->countryMap($patient->nationality);
        $patientInHealthtics->impb_occupation = $patient->occupation;
        $patientInHealthtics->impb_employer = 0;
        $patientInHealthtics->impb_status = $this->statusMap($patient->kodstatus);
        $patientInHealthtics->imc_id = 3; //USIM
        $patientInHealthtics->imclient_id = 1;
        $patientInHealthtics->impb_edited_by = 1;
        $patientInHealthtics->impb_edited_date = $editedDate;
        $patientInHealthtics->impb_edited_time = $editedTime;
        $patientInHealthtics->point_id = 0;
        $patientInHealthtics->save();

        $patientAddrInHealthtics = \App\Models\PatientAddress::where('impb_id', $patientInHealthtics->impb_id)->first();
        if (!$patientAddrInHealthtics)
        {
            $patientAddrInHealthtics = new \App\Models\PatientAddress;
        }

        $patientAddrInHealthtics->impb_id = $patientInHealthtics->impb_id;
        $patientAddrInHealthtics->impaddr_add1 = $patient->home_ad1;
        $patientAddrInHealthtics->impaddr_add2 = $patient->home_ad2;
        $patientAddrInHealthtics->impaddr_state = $this->countryMap($patient->home_country);
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

    public function citizenMap($name)
    {
        $model = \App\Models\Citizen::where('imctz_name_ss', $name)->first();
        if ($model)
        {
            return $model->imctz_id;
        }
        else
        {
            return 0;
        }
    }

    public function countryMap($name)
    {
        $model = \App\Models\Country::where('imct_name_ss', $name)->first();
        if ($model)
        {
            return $model->imct_id;
        }
        else
        {
            return 0;
        }
    }

    public function religionMap($name)
    {
        $model = \App\Models\Religion::where('imr_name_ss', $name)->first();
        if ($model)
        {
            return $model->imr_id;
        }
        else
        {
            return 0;
        }
    }

    public function genderMap($name)
    {
        $model = \App\Models\Gender::where('img_name_ss', $name)->first();
        if ($model)
        {
            return $model->img_id;
        }
        else
        {
            return 0;
        }
    }

    public function titleMap($name)
    {
        $model = \App\Models\Title::where('impfx_name_ss', $name)->first();
        if ($model)
        {
            return $model->impfx_id;
        }
        else
        {
            return 0;
        }
    }

    public function raceMap($name)
    {
        $model = \App\Models\Race::where('imrc_name_ss', $name)->first();
        if ($model)
        {
            return $model->imrc_id;
        }
        else
        {
            return 0;
        }
    }

    public function statusMap($name)
    {
        if ($name == 'Aktif')
        {
            return 1;
        }
        else
        {
            return 0;
        }
//        }
    }

}
