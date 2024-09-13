<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Carbon\CarbonInterface;

class UserTotalAttendanceNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public readonly string $name,
        public readonly string $attendanceHours,
        public readonly CarbonInterface $from,
        public readonly CarbonInterface $to,

    ) 
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
        ->subject("{$this->from->format('F')} Attendance Report")
        ->greeting("Hello {$this->name},")
        ->line("This is a report on the number of hours you attended during the period between {$this->from} - {$this->to}")
        ->line("You attended {$this->attendanceHours} hours on {$this->from->format('F Y ')} .")
        ->line("In case any questions arise, feel free to contact me!")
        ->line("We wish you the best of luck in attendance next month!")
        ->line(" Kind regards");

    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
