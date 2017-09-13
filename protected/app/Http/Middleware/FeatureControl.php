<?php

namespace App\Http\Middleware;

use Closure;

class FeatureControl
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $feature)
    {
      if(session('is_admin') == 1) return $next($request);
      $granted = (session('granted_features') != null) ? session('granted_features') : [];
      if(in_array($feature, $granted)) return $next($request);
      else return redirect('home')->withErrors(['e' => 'You don\'t have permission to access this page.']);

    }
}
