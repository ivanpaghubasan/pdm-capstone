<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\CompanyDetails;
use Company;

class ReplacedProductNotification extends Notification
{
    use Queueable;

    protected $replacement;
    protected $msg;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($replacement)
    {
        $this->replacement = $replacement;
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
            ->subject('Product Replaced')
            ->from(Company::getEmail(), Company::getCompanyName())
            ->markdown('mail.order.replaced_product', [
                'replacement' => $this->replacement,
                'company'=>CompanyDetails::first()
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
