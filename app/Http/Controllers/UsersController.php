<?php

namespace App\Http\Controllers;

use App\Http\Resources\HandleCollection;
use App\Http\Resources\HandleResource;
use App\Http\Resources\UserCollection;
use App\Models\Handle;
use App\Models\User;
use Illuminate\Http\Request;
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

        $variants = json_decode($request->variants ?? '[]');


        $tmp = $this->uploadPhotos($request->hasFile('uploaded_variants_image') ? $request->file('uploaded_variants_image') : null);
        $variants = [...$variants, ...$tmp];

        $id = $request->id ?? null;

        if (is_null($id))
            $handle = Handle::query()
                ->create([
                    "title" => $request->title ?? null,
                    'price' => $request->price ?? 0,
                    'variants'=>$variants
                ]);
        else {
            $handle = Handle::query()->find($id);

            if (is_null($handle))
                return response()->noContent(404);

            $handle->update([
                "title" => $request->title ?? null,
                'price' => $request->price ?? 0,
                'variants'=>$variants
            ]);

        }

        return new HandleResource($handle);
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
