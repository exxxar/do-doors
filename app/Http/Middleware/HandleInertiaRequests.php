<?php

namespace App\Http\Middleware;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {

        if (is_null(Auth::user()))
            return [
                ...parent::share($request),
                'auth' => [
                    'user' => null,
                    'roles' => [],
                    'permissions' => [],
                ]
            ];

        $user = User::query()
            ->with(["roles", "permissions"])
            ->where("id", Auth::user()->id)
            ->first();


        return [
            ...parent::share($request),
            'auth' => [
                'user' => $user,
                'roles' => !is_null($user) ? $user->roles->pluck('slug')->toArray() : [],
                'permissions' => !is_null($user) ? $user->permissions->pluck('slug')->toArray() : [],
            ],
        ];

        /*   return array_merge(parent::share($request), [
               //

           ]);*/
    }
}
