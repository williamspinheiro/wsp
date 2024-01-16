<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfilesRequest;
use App\Models\Profile;
use App\Repositories\PermissionsRepository;
use App\Repositories\ProfilesRepository;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    private $profiles;

    public function __construct(ProfilesRepository $profiles)
    {
        $this->profiles = $profiles;
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('index', Profile::class);
        return view('profile.list');
    }

    public function getList(Request $request)
    {
        return $this->profiles->returnDataTable($request->all(), $this->profiles->getList($request), Profile::class);
    }

    public function getListByName(string $name)
    {
        return response()->json(['data' => $this->profiles->getListByName($name)]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(PermissionsRepository $permissions)
    {
        $this->authorize('create', Profile::class);
        return view('profile.edit')->with(['profile' => new Profile])
                                    ->with(['permission' => $permissions->getList()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProfilesRequest $request, PermissionsRepository $permissions)
    {
        return $this->profiles->saveData($request, $permissions);
    }

    public function updateJson(Request $request)
    {
        return $this->profiles->updateJson($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Profile $profile)
    {
        return response()->json($profile);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Profile $profile, PermissionsRepository $permissions)
    {
        $this->authorize('edit', Profile::class);
        return view('profile.edit')->with(['profile' => $profile])
                                    ->with(['permissions' => $permissions->getList()]);
    }

    public function active(Request $request)
    {
        $this->authorize('active', Profile::class);
        return $this->profiles->updateActive($request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Profile $profile)
    {
        $this->authorize('destroy', Profile::class);
        return response()->json($profile->delete());
    }
}
