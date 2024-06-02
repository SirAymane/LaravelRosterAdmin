<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ValidateTeamForm
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
        $validator = Validator::make($request->all(), [
            "name" => "required|min:2|regex:/^[\pL'\s.]+$/u",
            "stadium" => "required|min:2|regex:/^[\pL'\s.]+$/u",
            "numMembers" => 'required|numeric|min:1',
            "budget" => "numeric|min:0",
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        return $next($request);
    }
}

