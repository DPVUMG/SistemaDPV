<?php

namespace App\Http\Middleware;

use App\Company;
use Closure;

class SystemExists
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request)
        {
            if(is_null(Company::where('system', true)->first()))
                return redirect()->route('company.index_sistema');
        }

        return $next($request);
    }
}
