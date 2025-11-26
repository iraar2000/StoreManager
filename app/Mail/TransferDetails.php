<?php

namespace App\Mail;

use App\Models\GeneralSetting;
use App\Models\MailSetting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToArray;

class TransferDetails extends Mailable
{
    use Queueable, SerializesModels, \App\Traits\MailInfo;

    /**
     * Create a new message instance.
     */
    public $data;
    public $general_setting;
    public $mail_setting;

    public function __construct($data)
    {
        $this->data = $data;
        $this->general_setting = GeneralSetting::first();
        $mail = MailSetting::latest()->first();
        $this->mail_setting = $mail ? $mail->toArray() : NULL;
        Log::info($this->mail_setting);
    }


    public function build()
    {

        if ($this->mail_setting) {
            $this->setMailInfo($this->mail_setting);
        }

        return $this->view('backend.mail.transfer_details')->subject('Transfer Details')->with([
            'mailData' => $this->data,
            'general_setting' => $this->general_setting
        ]);
    }
}
