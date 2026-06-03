<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PinSouvenirMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $event = $request->route('event');
        $eventId = $event instanceof \App\Models\Event ? $event->id : $event;

        if (!session("pin_souvenir_{$eventId}")) {

            return redirect()->route('pin.show', ['event' => $eventId, 'type' => 'souvenir']);

        }

        return $next($request);
    }
}