<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class ScheduleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'doctor_id' => 'required|exists:doctors,id',
            'schedule_title' => 'required|string|max:255|regex:/^\S*$/',
            'schedule_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'max_bookings' => 'required|integer|between:3,60',
        ];
    }

    /**
     * Custom messages for validation errors.
     */
    public function messages()
    {
        return [
            'doctor_id.required' => 'Doctor is required.',
            'doctor_id.exists' => 'The selected doctor does not exist.',
            'schedule_title.regex' => 'The schedule title must not contain spaces',
            'schedule_title.required' => 'Schedule title is required.',
            'schedule_date.required' => 'Schedule date is required.',
            'schedule_date.after_or_equal' => 'Schedule date cannot be before today.', // Custom error message
            'start_time.required' => 'Start time is required.',
            'end_time.required' => 'End time is required and must be after the start time.',
            'max_bookings.required' => 'Maximum bookings are required.',
            'max_bookings.between' => 'Maximum bookings must be between 20 and 60.',
        ];
    }

    /**
     * Add custom validation for time difference.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $schedule_date = Carbon::parse($this->input('schedule_date'));
            $start_time = Carbon::parse($this->input('start_time'));
            $end_time = Carbon::parse($this->input('end_time'));
            $current_time = Carbon::now(); // Current date and time

            // Ensure that start_time is not before current time if the schedule is for today
            if ($schedule_date->isToday() && $start_time->lt($current_time)) {
                $validator->errors()->add('start_time', 'The start time cannot be in the past for today\'s schedule.');
            }

            // Ensure that the difference between start_time and end_time is at least 5 hours and no more than 10 hours
            $hoursDifference = $start_time->diffInHours($end_time);

            if ($hoursDifference < 5) {
                $validator->errors()->add('end_time', 'The time difference between start time and end time must be at least 5 hours.');
            }

            if ($hoursDifference > 10) {
                $validator->errors()->add('end_time', 'The time difference between start time and end time cannot exceed 10 hours.');
            }
        });
    }

}
