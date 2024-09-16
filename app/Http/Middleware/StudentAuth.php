<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;

use App\Student;

use App\Exceptions\StudentReservedAccessOnlyException;

class StudentAuth
{
    protected $auth;

    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    public function handle($request, Closure $next, $guard = null)
    {
        if ($this->auth->guard($guard)->guest()) {
            return response('Unauthorized.', 401);
        }
		
	$user = $this->auth;
	$user_id = $user::id();
		
	throw_if(
	   !Student::where('user_id',$user_id)->exists(),
	   StudentReservedAccessOnlyException::class
        );

        return $next($request);
    }
}
