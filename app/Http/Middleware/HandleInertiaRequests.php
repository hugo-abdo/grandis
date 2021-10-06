<?php

namespace App\Http\Middleware;

use App\Http\Resources\NotificationResource;
use Illuminate\Http\Request;
use Inertia\Middleware;
use Laravel\Jetstream\Jetstream;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request)
    {
        return array_merge(parent::share($request), [
            'user' => function () use ($request) {
                if (!$request->user()) {
                    return;
                }

                if (Jetstream::hasTeamFeatures() && $request->user()) {
                    $request->user()->currentTeam;
                }

                return array_merge(
                    $request->user()->toArray(),
                    [
                        'all_teams' => Jetstream::hasTeamFeatures() ? $request->user()->allTeams() : null,
                        'two_factor_enabled' => !is_null($request->user()->two_factor_secret),
                    ]
                );
            },
            'notifications' => function () {
                if (!auth()->guest()) {
                    return NotificationResource::collection(
                        auth()->user()->notifications()
                            ->take(10)
                            ->orderBy('created_at', 'desc')
                            ->get()
                    );
                }
            },
        ]);
    }
}
