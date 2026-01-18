<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VerifyImageURL
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->isMethod('post')) {
            $imageUrl = $request->input('image-url');
            if (!$imageUrl || !preg_match('/\.(jpe?g|png|gif|webp|bmp|svg)$/i', $imageUrl)) {
                abort(403, 'Forbidden: Invalid image URL.');
            }
        }

        return $next($request);
    }
}