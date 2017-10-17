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
        $reportData = Report::where('created_at', '>' ,Carbon::now()->format('Y-m-d'))
                        ->distinct('center_id')
                        ->pluck('center_id');

        if(count($reportData) > 0) {

            $emailTo = Report::getToAddress($reportData);
            $emailCc = Report::getCcAddress($reportData);
            $emailBcc = Report::getBccAddress($reportData);

            if (!empty($emailTo) || !empty($emailBcc) || !empty($emailCc)) {

                $dataCenterOne = Report::where('center_id',Report::CENTER_ONE)
                    ->where('created_at', '>' ,Carbon::now()->format('Y-m-d'))
                    ->count();
                $dataCenterTwo = Report::where('center_id',Report::CENTER_TWO)
                    ->where('created_at', '>' ,Carbon::now()->format('Y-m-d'))
                    ->count();

                $total =  $dataCenterOne+$dataCenterTwo;

                if($total > 0) {
                    $data = array('centerOne' => $dataCenterOne,
                        'centerTwo' => $dataCenterTwo,
                        'total' => $total,
                    );

                    $subject_content = "[DAILY PATIENT REPORT]".Carbon::now()->format('d-m-Y');
                    try {
                        Mail::send('emails.daily_report', $data, function ($message) use ($emailTo, $emailCc, $emailBcc, $subject_content) {
                            if(empty($emailTo)){
                                $message->to("admin@simplify-crm.com");
                            }else{
                                $message->to($emailTo);
                            }
                            $message->cc($emailCc);
                            $message->bcc($emailBcc);
                            $message->subject($subject_content);
                        });
                    } catch (\Exception $e) {
                        return redirect()->back()->withInput()->withErrors($e->getMessage());
                    }
                }
                return $this->info('Email send!!');
            }
            return $this->info('Email not send!!');
        }
        return $this->info('Center Id Not Available!!');
    }
}
