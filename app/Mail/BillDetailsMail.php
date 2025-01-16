<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BillDetailsMail extends Mailable
{
    use Queueable, SerializesModels;

    public $registration;
    public $otherCharges;
    public $advancePayments;
    public $finalBill;

    public function __construct($registration, $otherCharges, $advancePayments, $finalBill)
    {
        $this->registration = $registration;
        $this->otherCharges = $otherCharges;
        $this->advancePayments = $advancePayments;
        $this->finalBill = $finalBill;
    }

    public function build()
    {
        return $this->view('emails.bill-details')
                    ->subject('Your Bill Details - BBQ HUB');
    }
}
