<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\CompanyDetails;
use Company;

class ActivationLink extends Notification
{
    use Queueable;

    protected $cust;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($cust)
    {
        $this->cust = $cust;
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
        $url = url('/email-verified/'.$this->cust->email.'/'.$this->cust->token);


        return (new MailMessage)
                    ->subject('Email Verification')
                    ->from(Company::getEmail(), Company::getCompanyName())
                    ->greeting('Hi '.$this->cust->first_name.',')
                    ->line('To verify your email please click the button below.')
                    ->action('Verify Email', $url)
                    ->line('Thank you for creating your account at '.Company::getCompanyName().'.');
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
