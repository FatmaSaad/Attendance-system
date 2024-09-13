<?php

namespace App\Services;

use App\Models\CheckIn;
use App\Models\CheckOut;
use App\Repositories\AttendanceRepository;


class AttendanceService
{
    protected $attendance;

    public function __construct(CheckIn $check_in, CheckOut $check_out)
    {
        $this->attendance = new AttendanceRepository($check_in, $check_out);
    }
    /**
     * Display a listing of all user check-ins/check-outs.
     */
    public function index()
    {
        return $this->attendance->index();
    }
    /**
     * Get total number of hours that user attended during a specific period of time by using from/to date.
     */
    public function attendanceHours($request)
    {
        return $this->attendance->attendanceHours($request);
    }

    /**
     * Check in time will be fetched from the now time ,
     */
    public function checkIn()
    {
        return $this->attendance->checkIn();
    }
    /**
     * Check out time will be fetched from the now time ,
     */
    public function checkOut()
    {
        return $this->attendance->checkOut();

    }
}
