<?php



namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Dangky extends Mailable
{
    use Queueable, SerializesModels;

    public $contactData;

    public function __construct($contactData)
    {
        $this->contactData = $contactData;
    }

    public function build()
    {
        return $this->subject('Tin nhắn liên hệ mới')
                    ->view('web3.emails.dangky') // View này chứa nội dung gửi mail
                    ->with([
                        'contactData' => $this->contactData,
                    ]);
    }
    
}