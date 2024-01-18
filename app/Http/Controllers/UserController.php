<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserProfilesRequest;
use App\Http\Requests\UsersRequest;
use App\Http\Resources\UsersResource;
use App\Models\User;
use App\Repositories\UsersRepository;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $users;

    public function __construct(UsersRepository $users)
    {
        $this->users = $users;
    }

    public function loginByUser(User $user, Request $request)
    {
        try {
            if (Hash::check(buildTokenByUser($user), urldecode($request->token))) {
                Auth::login($user);
        
                return redirect()->action([\App\Http\Controllers\HomeController::class, 'index']);
            } else {
                throw new Exception("Check if the token is expired.");
            }
        } catch(Exception $exception) {
            return json_encode(['response' => $exception->getMessage(), 'status' => 'error'], 403);
        }
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('index', User::class);
        return view('user.list');
    }

    public function profile()
    {
        return view('user.profile')->with(['user' => Auth::user()]);
    }

    public function getList(Request $request)
    {
        return $this->users->returnDataTable($request->all(), $this->users->getList($request), User::class, UsersResource::class);
    }

    public function getListByName(string $userName)
    {
        return response()->json(['data' => $this->users->getListByName($userName)]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', User::class);
        return view('user.edit')->with(['user' => new User]);
    }

    public function saveProfile(UserProfilesRequest $request)
    {
        if (Auth::user()->id != $request->id || Auth::user()->profile_id != $request->profile_id)
        {
            return back()->withInput()->withErrors('Dados incorretos!');
        }
        
        return $this->users->saveProfile($request);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UsersRequest $request)
    {
        return $this->users->saveData($request);
    }

    public function updateJson(Request $request)
    {
        return $this->users->updateJson($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return $this->users->returnData($user);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $this->authorize('edit', User::class);
        return view('user.edit')->with(['user' => $user]);
    }

    public function active(Request $request)
    {
        $this->authorize('active', User::class);
        return $this->users->updateActive($request);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $this->authorize('destroy', User::class);
        return response()->json($user->delete());
    }
}
