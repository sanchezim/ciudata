<?php

namespace App\Http\Middleware\Api\Config;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;

class LanguageMiddleware
{

    protected $languageHeader = 'Accept-Language';
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->hasHeader($this->languageHeader)) {
            return response()->json([
                'code'      => Response::HTTP_BAD_REQUEST,
                'message'   => 'Header Accept-Language  not send',
            ], Response::HTTP_BAD_REQUEST);
        }
        $header = $request->header($this->languageHeader);

        if (!in_array($header, config('apiConfig.LANGS'))) {
            return response()->json([
                'code'      => Response::HTTP_BAD_REQUEST,
                'message'   => 'Header not valid',
                'headersValids'   => config('apiConfig.LANGS'),
            ], Response::HTTP_BAD_REQUEST);
        }
        App::setLocale($header);
        return $next($request);
    }
}
