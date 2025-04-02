<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Order;

class PaymentSuccessMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;

    /**
     * Tạo instance của PaymentSuccessMail.
     *
     * @param Order $order
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Xây dựng email.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Xác nhận thanh toán thành công')
                    ->view('emails.payment_success')
                    ->with([
                        'order' => $this->order,
                        'customerEmail' => $this->order->email, // Email khách hàng
                        'customerName' => $this->order->name, // Tên khách hàng
                    ]);
    }
}

