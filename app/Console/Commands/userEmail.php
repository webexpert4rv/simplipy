<?php

namespace App\Console\Commands;

use App\Report;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class userEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:dailyEmail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send daily e-mails to a user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        //return $this->info('Inside handler function!!'); 
        
     /*   Mail::raw('This is test email',function($message){
            $message->to('rajat_jain@rvtechnologies.co.in');
        });

        return $this->info('Email send!!');*/

        $reportData = Report::where('created_at', '>' ,Carbon::yesterday()->format('Y-m-d'))
                        ->distinct('center_id')
                        ->pluck('center_id');

        if(count($reportData) > 0) {



            $emailTo = Report::getToAddress($reportData);
            $emailCc = Report::getCcAddress($reportData);
            $emailBcc = Report::getBccAddress($reportData);

            if (!empty($emailTo) || !empty($emailBcc) || !empty($emailCc)) {


                $dataCenterOne = Report::where('center_id',Report::CENTER_ONE)
                    ->where('created_at', '>' ,Carbon::yesterday()->format('Y-m-d'))
                    ->count();
                $dataCenterTwo = Report::where('center_id',Report::CENTER_TWO)
                    ->where('created_at', '>' ,Carbon::yesterday()->format('Y-m-d'))
                    ->count();

                $total =  $dataCenterOne+$dataCenterTwo;

                if($total > 0) {
                    $data = array('centerOne' => $dataCenterOne,
                        'centerTwo' => $dataCenterTwo,
                        'total' => $total,
                    );

                    $subject_content = "[Rapport​ Quotidien​ Messagerie​ Simplify]​ ".Carbon::now()->format('d-m-Y');
                    try {
                         Log::info('Jain');
                        Mail::send('emails.daily_report', $data, function ($message) use ($subject_content) {
                          
                            $message->to("testing.rvtech@gmail.com");
                          
                            $message->subject($subject_content);
                        });
                    } catch (\Exception $e) {
                        Log::info($e->getMessage());
                        return redirect()->back()->withInput()->withErrors($e->getMessage());
                    }
                    return $this->info('Email send!!');
                }
                return $this->info('Email send!!');
            }
            return $this->info('Email not send!!');
        }
        return $this->info('Center Id Not Available!!');
    }
}
