<?php

namespace App\Console\Commands;

use App\Report;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class monthlyEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:monthlyEmail';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send monthly e-mails to a user';

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
        $reportData = Report::where('created_at', '>' ,Carbon::now()->format('Y-m'))
            ->distinct('center_id')
            ->pluck('center_id');

        if(count($reportData) > 0) {

            $emailTo = Report::getToAddress($reportData);
            $emailCc = Report::getCcAddress($reportData);
            $emailBcc = Report::getBccAddress($reportData);

            if (!empty($emailTo) || !empty($emailBcc) || !empty($emailCc)) {

                $dataCenterOne = Report::where('center_id',Report::CENTER_ONE)
                    ->where('created_at', '>' ,Carbon::now()->format('Y-m'))
                    ->count();
                $dataCenterTwo = Report::where('center_id',Report::CENTER_TWO)
                    ->where('created_at', '>' ,Carbon::now()->format('Y-m'))
                    ->count();

                $total =  $dataCenterOne+$dataCenterTwo;

                if($total > 0) {
                    $data = array('centerOne' => $dataCenterOne,
                        'centerTwo' => $dataCenterTwo,
                        'total' => $total,
                    );

                    $subject_content = "[Rapport​ Mensuel​ ​Messagerie​ Simplify]​ ".Carbon::now()->format('F Y');
                    try {
                        Mail::send('emails.monthly_report', $data, function ($message) use ($subject_content) {
                            /*if(empty($emailTo)){
                                $message->to("testing.rvtech@gmail.com");
                            }else{
                                $message->to($emailTo);
                            }*/
                            $message->to("rajat_jain@rvtechnologies.co.in");
                            /*  $message->cc($emailCc);
                              $message->bcc($emailBcc);*/
                            $message->subject($subject_content);
                        });

                    } catch (\Exception $e) {
                        return redirect()->back()->withInput()->withErrors($e->getMessage());
                    }
                    return redirect('user/reports')->with('success', 'Email send!!');
                }
                return redirect('user/reports')->with('success', 'Email send!!');
            }
            return redirect('user/reports')->with('success', 'Email not send!!');
        }
        return redirect('user/reports')->with('success', 'Center Id Not Available!!');
    }
}
