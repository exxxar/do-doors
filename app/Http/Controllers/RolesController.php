<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\RoleCollection;
use App\Http\Resources\RoleResource;
use App\Models\Role;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;


class RolesController extends Controller
{
    use Utility;

    public function index(Request $request): \Inertia\Response
    {
        return Inertia::render('Admin/RolesPage');
    }

    public function getRolesList(Request $request): RoleCollection
    {

        $search = $request->search ?? null;
        $order = $request->order ?? "id";
        $direction = $request->direction ?? "asc";

        $size = $size ?? config('app.results_per_page');

        $roles = Role::query();

        if (!is_null($search))
            $roles = $roles
                ->where("name", 'like', "%$search%");

        $roles = $roles->orderBy($order, $direction);

        return new RoleCollection($roles->paginate($size));
    }


    public function store(Request $request)
    {
        $request->validate([
            "name" => "required",
            "slug" => "required"
        ]);


        $id = $request->id ?? null;

        $tmp = [
            "name" => $request->name ?? null,
            'slug' => $request->slug ?? null,

        ];

        if (is_null($id))
            $role = Role::query()
                ->create($tmp);
        else {
            $role = Role::query()->find($id);

            if (is_null($role))
                return response()->noContent(404);

            $role->update($tmp);

        }

        return new RoleResource($role);
    }


    public function destroy(Request $request, $id): \Illuminate\Http\Response
    {
        $role = Role::query()->find($id);

        if (is_null($role))
            return response()->noContent(404);

        $role->delete();

        return response()->noContent(200);
    }
}
