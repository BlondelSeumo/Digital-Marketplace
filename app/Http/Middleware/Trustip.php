<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Trustip as ProxyCheck;

class Trustip
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (extension('trustip')->status) {
            try {
                $trustip = ProxyCheck::check(getIp());
                if ($trustip->status == "error") {
                    throw new Exception($trustip->message);
                }

                if ($trustip->status == "success" && $trustip->data->is_proxy == true) {
                    toastr()->error(translate('We could not complete the process, please try again letter'));
                    return back();
                }
            } catch (Exception $e) {
                throw new Exception($e->getMessage());
            }
        }

        return $next($request);
    }
}
