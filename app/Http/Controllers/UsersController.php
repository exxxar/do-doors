<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UsersController extends Controller
{
    /**
     * Display all users
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        return Inertia::render('Admin/UsersPage');
    }

    public function getUsersList(Request $request): UserCollection
    {

        $search = $request->search ?? null;
        $order = $request->order ?? "id";
        $direction = $request->direction ?? "asc";

        $size = $size ?? config('app.results_per_page');

        $users = User::query();

        if (!is_null($search))
            $users = $users
                ->where("name", 'like', "%$search%")
                ->orWhere("email", 'like', "%$search%")
                ->orWhere("id", 'like', "%$search%");

        $users = $users->orderBy($order, $direction);

        return new UserCollection($users->paginate($size));
    }


    public function store(Request $request)
    {
        $request->validate([
            "name" => "required",
            "email" => "required",
        ]);


        $roles = is_null($request->roles ?? null)? null : json_decode($request->roles);
        $permissions = is_null($request->permissions ?? null)? null : json_decode($request->permissions);

        $id = $request->id ?? null;

        if (is_null($id))
            $user = User::query()
                ->create([
                    "name" => $request->name ?? null,
                    'email' => $request->email ?? null,
                    'password' => is_null($request->password ?? null) ? bcrypt("password") : bcrypt($request->password),
                ]);
        else {
            $user = User::query()->find($id);

            if (is_null($user))
                return response()->noContent(404);

            $user->update([
                "name" => $request->name ?? null,
                'email' => $request->email ?? null,
            ]);

            if (!is_null($request->password ?? null))
            {
                $user->password =  bcrypt($request->password);
                $user->save();
            }
        }

        if (is_null($roles))
            $user->roles()->detach();
        else
        {

            $roles = array_values(Collection::make($roles)
                ->pluck("id")->toArray());

            $user->roles()->sync($roles);
        }


        if (is_null($permissions))
            $user->permissions()->detach();
        else
        {
            $permissions = array_values(Collection::make($permissions)
                ->pluck("id")->toArray());

            $user->permissions()->sync($permissions);
        }


        return new UserResource($user);
    }


    public function destroy(Request $request, $id): \Illuminate\Http\Response
    {
        $user = User::query()->find($id);

        if (is_null($user))
            return response()->noContent(404);

        $user->delete();

        return response()->noContent(200);
    }
}
