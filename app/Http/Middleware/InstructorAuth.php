<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;

use App\Instructor;

use App\Exceptions\InstructorReservedAccessOnlyException;

class InstructorAuth
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
			!Instructor::where('user_id',$user_id)->exists(),
			 InstructorReservedAccessOnlyException::class
		);
		
        return $next($request);
    }
}