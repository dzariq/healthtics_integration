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
//        print_r($test);
//        die;

        $patientData = new \App\Models\PatientData;
        $patientData->changeConnection('mysql');
        $data = $patientData->limit(10)->get();
        print_r($data);
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
        $test = DB::table('eklinikal_all_data')->limit(1)->get();
        print_r($test);
        die;

        $patientData = new \App\Models\PatientData;
        $patientData->changeConnection('mysql');
        $data = $patientData->limit(10)->get();
        print_r($data);
    }

>>>>>>> 6a78c1eb57c19116476fa8ed41dda4111da4cb8a
}