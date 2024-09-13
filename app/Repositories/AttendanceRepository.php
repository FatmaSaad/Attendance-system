<?php

namespace App\Repositories;

use App\Enums\UserStatuses;
use App\Models\CheckIn;
use App\Models\CheckOut;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class AttendanceRepository
{
    use ApiResponse;
    /**
     * @var CheckIn
     * @var CheckOut
     */
    protected $attendance;

    /**
     * UserRepository constructor.
     *
     * @param CheckIn $checkIn
     * @param  CheckOut $checkOut
     */
    public function __construct(Model $checkIn, Model $checkOut)
    {
        $this->checkIn = $checkIn;
        $this->checkOut = $checkOut;

    }
    /**
     * Display a listing of all user check-ins/check-outs.
     * 
     * Method returns a JsonResponse responsible for user attendance information 
     *
     * @return  $allCheckIns - a collection of `CheckIn` with `checkOut` in descending order. 
     */
    public function index()
    {
        return Auth::user()->allCheckIns;
    }
    /**
     * If user sent (from) and (to) parametars in request body
     * 
     * Get total number of hours that user attended during a specific period of time by using from/to date.
     * Example (if Authenticated user entered from 2024-1-1 to 2024-3-13 then he/she can view the
     * total number of hours check-ins/check-outs During this period.
     *
     * If empty request body
     *
     * Get total number of hours that user attended
     * 
     * 
     */
    public function attendanceHours($request)
    {
        $user = Auth::user();

        if ($request->has(['from', 'to'])) {

            $startDate = Carbon::parse($request->from)->startOfDay();
            $endDate = Carbon::parse($request->to)->endOfDay();
            return getUserAttendanceTotalHours($user, $startDate, $endDate);

        } else {
            return getUserAttendanceTotalHours($user);
        }
    }
    /**
     * Check in time will be fetched from the now time , 
     * Example ( if Authenticated user check in “2024-1-1 12:33:44” then this time will be saved as check-in time )
     *
     */
    public function checkIn()
    {
        $user = Auth::user();
        $user->status = UserStatuses::ACTIVE->value;
        $user->save();
        $checkIn = $user->checkIns()->create([
            'created_at' => now()

        ]);

        return $checkIn;
    }
    /**
     * Check out time will be fetched from the now time ,
     * Example ( if Authenticated user check out “2024-1-1 12:33:44” then this time will be saved as check-out time )
     * 
     */
    public function checkOut()
    {
        $user = Auth::user();
        $user->status = UserStatuses::INACTIVE->value;
        $user->save();
        $checkOut = $user->activecheckIn->checkOut()->create([
            'created_at' => now()

        ])->load('checkIn');

        return $checkOut;

    }
}