<?php

namespace Tests\Feature\Notifications;

use App\Models\User;
use App\Notifications\UserTotalAttendanceNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class UserTotalAttendanceNotificationTest extends TestCase
{
    
    /**
     *  Test Case for sending Notification to all users when call artisan command (app:send-attendance-notifications) successfully
     */
    public function test_send_notification(): void
    {
        Notification::fake();
        Artisan::call('app:send-attendance-notifications');
        $users = User::all();
        foreach ($users as $user) {

            Notification::assertSentTo($user, UserTotalAttendanceNotification::class);
        }
    }
}
