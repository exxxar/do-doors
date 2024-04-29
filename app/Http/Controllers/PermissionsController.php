<?php

namespace App\Http\Controllers;

use App\Http\Resources\PermissionCollection;
use App\Http\Resources\PermissionResource;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class PermissionsController extends Controller
{
    use Utility;

    public function index(Request $request): \Inertia\Response
    {
        return Inertia::render('Admin/PermissionsPage');
    }

    public function getPermissionsList(Request $request): PermissionCollection
    {

        $search = $request->search ?? null;
        $order = $request->order ?? "id";
        $direction = $request->direction ?? "asc";

        $size = $size ?? config('app.results_per_page');

        $permissions = Permission::query();

        if (!is_null($search))
            $permissions = $permissions
                ->where("name", 'like', "%$search%");

        $permissions = $permissions->orderBy($order, $direction);

        return new PermissionCollection($permissions->paginate($size));
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
            $permission = Permission::query()
                ->create($tmp);
        else {
            $permission = Permission::query()->find($id);

            if (is_null($permission))
                return response()->noContent(404);

            $permission->update($tmp);

        }

        return new PermissionResource($permission);
    }


    public function destroy(Request $request, $id): \Illuminate\Http\Response
    {
        $permission = Permission::query()->find($id);

        if (is_null($permission))
            return response()->noContent(404);

        $permission->delete();

        return response()->noContent(200);
    }
}
