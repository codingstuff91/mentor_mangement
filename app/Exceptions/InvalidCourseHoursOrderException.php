<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;

class InvalidCourseHoursOrderException extends Exception
{
    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function render(Request $request)
    {
        return response()->view('errors.invalid-course-hours-order', [], 400);
    }
}
