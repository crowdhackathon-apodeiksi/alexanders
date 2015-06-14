<?php namespace App\Http\Middleware;

use App\Receipt;
use Closure;

class ReceiptExists {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
        $receipt_id=$request->segment(4);
        if(!Receipt::find($receipt_id)){
           abort(404);
        }
		return $next($request);
	}

}
