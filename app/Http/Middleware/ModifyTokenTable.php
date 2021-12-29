<?php

namespace App\Http\Middleware;

use App\Models\TokenConnectionOne;
use App\Models\TokenConnectionTwo;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;

class ModifyTokenTable
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
        $token = $request->bearerToken();
        if ($token)
        {
            Sanctum::usePersonalAccessTokenModel(TokenConnectionOne::class);
            $model = Sanctum::$personalAccessTokenModel;
            $accessToken = $model::findToken($token);
            if (!$accessToken) 
            {
                Sanctum::usePersonalAccessTokenModel(TokenConnectionTwo::class);
                Config::set('database.default', 'mysql_2');
                $model = Sanctum::$personalAccessTokenModel;
                $accessToken = $model::findToken($token);
            }
        }
        return $next($request);
    }
}
