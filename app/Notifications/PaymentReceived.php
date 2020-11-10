<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\CompanyDetails;
use Company;

class PaymentReceived extends Notification
{
    use Queueable;

    protected $order;
    protected $date;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($order, $date)
    {
        $this->order = $order;
        $this->date = $date;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {

        return (new MailMessage)
            ->subject('Payment Received')
            ->from(Company::getEmail(), Company::getCompanyName())
            ->markdown('mail.order.received_payment', [
            'url' => route('customer.view_order', ['order' => $this->order->number]), 
            'order' => $this->order, 
            'date' => $this->date,
            'company' => CompanyDetails::first()
        ]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
