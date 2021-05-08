<?php

namespace App\Http\Middleware;

use App\Models\Account;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class ValidateAccount
{
    public function handle(
        Request $request,
        Closure $next
    ): Response {
        $params = $request->route()->parameters;
        if(empty($params['accountId']) === false) {
            $account = Account::where('id', $params['accountId'])->first();
            if (
                empty($account) === true
                || $account->user_id !== Auth::id()
            ) {
                Session::flash('error', 'Access denied');

                return redirect('/dashboard');
            }
        }

        return $next($request);
    }
}
