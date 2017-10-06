<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CampaignRequest extends Mailable
{
    use Queueable, SerializesModels;
    public $campaignRequest;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(\App\CampaignRequest $campaignRequest)
    {
        $this->campaignRequest = $campaignRequest;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.campaign');
    }
}
