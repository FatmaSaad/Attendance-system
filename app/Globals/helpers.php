<?php

use Carbon\Carbon;

if (!function_exists('differenceInHours')) {

    /**
     * @param $array
     * @return string
     */
    function differenceInHours($startdate, $enddate)
    {
        $starttimestamp = strtotime($startdate);
        $endtimestamp = strtotime($enddate);
        $difference = abs($endtimestamp - $starttimestamp) / 3600;
        return $difference;
    }

}


if (!function_exists('getUserAttendanceTotalHours')) {

    /**
     * @param $array
     * @return string
     */
    function getUserAttendanceTotalHours($user, $startDate = null, $endDate = null)
    {
        $checkIns = [];

        if ($startDate || $endDate) {

            $checkIns = $user->checkIns->whereBetween('created_at', [$startDate, $endDate])->pluck('created_at', 'checkOut.created_at')->toArray();

        } else {
            $checkIns = $user->checkIns->pluck('created_at', 'checkOut.created_at')->toArray();

        }
        $attendanceHours = 0;
        foreach ($checkIns as $checkIn => $checkOut) {
            $attendanceHours += differenceInHours($checkIn, $checkOut);
        }

        return (object) [
            'hours' => hoursToTime($attendanceHours),
            'from' => $startDate,
            'to' => $endDate,
        ];
    }

}
if (!hoursToTime('differenceInHours')) {

    /**
     * @param $array
     * @return string
     */

    function hoursToTime($hours)
    {
        $totalSeconds = $hours * 3600; // Convert hours to seconds
        $hours = floor($totalSeconds / 3600);
        $minutes = floor(($totalSeconds % 3600) / 60);
        $seconds = $totalSeconds % 60;

        return sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
    }

}