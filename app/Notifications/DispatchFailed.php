<?php

namespace App\Notifications;

use App\Models\FailedJob;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\SlackAttachment;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;

class DispatchFailed extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(private FailedJob $failedJob)
    {
    }

    public function via($notifiable)
    {
        return ['slack'];
    }

    public function toSlack($notifiable)
    {
        $snoozeUrl3 = $this->failedJob->signedSnoozeUrl(3);
        $snoozeUrlEver = $this->failedJob->signedSnoozeUrl(24 * 365 * 10);

        return (new SlackMessage)
            ->error()
            ->from('DispatchAgencies')
            ->content("Dispatch failed for *{$this->failedJob->agency->short_name}* ```{$this->failedJob->exception}```")
            ->attachment(function (SlackAttachment $attachment) use ($snoozeUrl3) {
                $attachment->title('Snooze for 3 hours', $snoozeUrl3);
            })
            ->attachment(function (SlackAttachment $attachment) use ($snoozeUrlEver) {
                $attachment->title('Snooze forever', $snoozeUrlEver);
            });
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

    public function viaQueues()
    {
        return [
            'slack' => 'notifications',
        ];
    }
}
