<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\CheckOutResource;
use App\Traits\ApiResponse;
use App\Services\AttendanceService;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AttendanceRequest;
use App\Http\Resources\AttendanceResource;
use App\Http\Resources\CheckInResource;

class AttendanceController extends Controller
{
    use ApiResponse;
    protected $attendance_service;
    public function __construct(AttendanceService $service)
    {
        $this->attendance_service = $service;
    }
    /**
     * Display a listing of all user check-ins/check-outs.
     * 
     * * Method returns a JsonResponse responsible for user attendance information 
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        try {
            $data = $this->attendance_service->index();
            return $this->successResponse(AttendanceResource::collection($data));
        } catch (\Exception $e) {
            return $this->errorResponse(__('auth.Something went wrong'), 422);
        }
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
     * * Method accepts an instance of `AttendanceRequest`
     *  and returns a JsonResponse responsible for attendance hours.
     *
     * @param AttendanceRequest $request - An instance of `RegisterRequest`
     *
     * @return JsonResponse
    */
    public function attendanceHours(AttendanceRequest $request): JsonResponse
    {
        try {
            $data = $this->attendance_service->attendanceHours($request);
            return $this->successResponse('You worked ' . $data->hours . ' hours' . ($data->from && $data->to ? ' during the period between ' . $data->from . ' - ' . $data->to : '.'));

        } catch (\Exception $e) {
            return $this->errorResponse(__('auth.Something went wrong'), 422);
        }
    }

    /**
     * Check in time will be fetched from the now time , 
     * Example ( if Authenticated user check in “2024-1-1 12:33:44” then this time will be saved as check-in time )
     * 
     * * Method returns a JsonResponse responsible check in date-time and user status In\Out .
     *
     * @return CheckInResource JsonResponse
     */
    public function checkIn(): JsonResponse
    {
        try {
            $data = $this->attendance_service->checkIn();
            return $this->successResponse(new CheckInResource($data), __('messages.questions.created'));

        } catch (\Exception $e) {
            return $this->errorResponse(__('auth.Something went wrong'), 422);
        }
    }
    /**
     * Check out time will be fetched from the now time ,
     * Example ( if Authenticated user check out “2024-1-1 12:33:44” then this time will be saved as check-out time )
     * 
     * * Method returns a JsonResponse responsible check out date-time and user status In\Out .
     *
     * @return CheckOutResource JsonResponse
     */
    public function checkOut(): JsonResponse
    {
        try {
            $data = $this->attendance_service->checkOut();
            return $this->successResponse(new CheckOutResource($data), __('messages.questions.created'));

        } catch (\Exception $e) {
            return $this->errorResponse(__('auth.Something went wrong'), 422);
        }
    }



}
