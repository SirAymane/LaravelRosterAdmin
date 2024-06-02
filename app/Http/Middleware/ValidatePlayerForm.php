<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ValidatePlayerForm
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Define validation rules for each form field
        $validationRules = [
            "first_name" => "required|min:2|regex:/^[\pL'\s]+$/u",
            "last_name" => "required|min:2|regex:/^[\pL'\s]+$/u",
            "position" => "required|in:Point Guard,Shooting Guard,Small Forward,Power Forward,Center",
            "salary" => "required|numeric|min:0",
        ];

        // Validate the received fields from the HTTP request using the defined rules
        $request->validate($validationRules);

        return $next($request);
    }
}
