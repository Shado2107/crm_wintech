<?php

namespace App\Http\Middleware;

use Response;
use Closure;
use Illuminate\Http\Request;
use App\Models\User;

use DB;

use Carbon\Carbon;

class EnsureTokenIsValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
		$token = $request->header('Authorization');

        $token = DB::table('tokens')
        ->select('users.*', 'tokens.*')
        ->join('users', 'users.id', 'tokens.user_id')
        ->where('tokens.token', $token)
        ->first();

        //Token not exist
        if(empty($token))
            return response()->json(['error' => 'Unauthorized.'],401);   
        
        //User Token valid or not
        $today = Carbon::now();
        
        $expired_at = Carbon::createFromFormat('Y-m-d H:i:s', $token->expired_at);

        $expire = $today->gt($expired_at);

        if(!$token->state || $expire)
            return response()->json(['error' => 'Unauthorized.'],401);   

        return $next($request);
    }
}
