<?php

namespace App\Console\Commands;

use App\Notifications\AttandanceTotalHours;
use Illuminate\Console\Command;
use App\Models\User;
use App\Notifications\UserTotalAttendanceNotification;
use Carbon\Carbon;
use Illuminate\Http\Request;
class SendAttendanceNotifications extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-attendance-notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::all();

        $start = new Carbon('first day of last month');
        $start = $start->startOfMonth();
        $end = new Carbon('last day of last month');
        $end = $end->endOfMonth();

        if (!empty($users)) {
            foreach ($users as $user) {
                if($user::where('email', $user['email'])->exists() ){
                    $attendanceTotalHours=getUserAttendanceTotalHours($user,$start,$end);
                    //call notification
                     $user->notify(new UserTotalAttendanceNotification(
                        name: $user->name,
                        attendanceHours: $attendanceTotalHours->hours,
                        from : $start,
                        to : $end,
                    ));
                }
                sleep(2); // Delay the script execution for 2 seconds
            }
        }
    }
}
    

