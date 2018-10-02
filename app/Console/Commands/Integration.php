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
        $test = DB::table('eklinikal_all_data')->limit(5)->get();
        print_r($test);die;
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
        $test = DB::table('eklinikal_all_data')->limit(5)->get();
//        print_r($test);
//        die;

        $patientData = new \App\Models\PatientData;
        $patientData->changeConnection('mysql');
        $data = $patientData->limit(10)->get();
        print_r($data);
    }

}
>>>>>>> 742f544e38a531b80d1e7f91f204e118b0d33c5a
