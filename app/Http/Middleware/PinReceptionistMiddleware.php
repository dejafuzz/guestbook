<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PinReceptionistMiddleware
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
        
        if (!session("pin_receptionist_{$eventId}")) {

            return redirect()->route('pin.show', ['event' => $eventId, 'type' => 'receptionist']);

        }

        return $next($request);
    }
}