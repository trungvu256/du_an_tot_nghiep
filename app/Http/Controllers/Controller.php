<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Mail;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function gmail () {
        $name = "Thư cảm ơn";
    Mail::send('email', compact('name'), function ($email) {
        $email->from('uytdph47353@fpt.edu.vn', 'John Doe');
        $email->sender('uytdph47353@fpt.edu.vn', 'John Doe');
        $email->to('uytdph47353@fpt.edu.vn', 'John Doe');
        $email->cc('uytdph47353@fpt.edu.vn', 'John Doe');
        $email->bcc('uytdph47353@fpt.edu.vn', 'John Doe');
        $email->replyTo('uytdph47353@fpt.edu.vn', 'John Doe');
        $email->subject('Subject');
        $email->priority(3);
        $email->attach('pathToFile');
    });
    }
}
