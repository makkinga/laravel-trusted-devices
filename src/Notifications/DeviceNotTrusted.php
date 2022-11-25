<?php

namespace Makkinga\TrustedDevices\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Makkinga\TrustedDevices\Models\TrustedDevice;
use Illuminate\Notifications\Messages\MailMessage;

class DeviceNotTrusted extends Notification
{
    use Queueable;

    public TrustedDevice $device;
    public $verificationToken;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(TrustedDevice $device, string $verificationToken)
    {
        $this->device            = $device;
        $this->verificationToken = $verificationToken;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)->markdown('trusted-devices::mail.device-not-trusted', [
            'user'              => $notifiable,
            'device'            => $this->device,
            'verificationToken' => $this->verificationToken,
            'salutation'        => trans('trusted-devices::mail.salutation'),
            'bodyTop'           => trans('trusted-devices::mail.body_top'),
            'bodyBottom'        => trans('trusted-devices::mail.body_bottom'),
            'buttonText'        => trans('trusted-devices::mail.button_text'),
            'footer'            => trans('trusted-devices::mail.footer'),
        ]);
    }
}
