<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Http\Request;

class UsersRepository extends Repository
{
    protected $user;

    public function __construct(User $user)
    {
        $this->model = $user;
    }
    
    public function getList(Request $request)
    {
        return $this->model->query()
                    ->withFilter($request);
    }

    public function getLIstByName(string $userName)
    {
        return $this->model->query()
                        ->byName($userName)
                        ->get();
    }

    public function saveData(Request $request)
    {
        try {
            if ($request->has('id')) {
                $message = 'Usuário alterado com sucesso.';
            } else {
                $message = 'Usuário cadastrado com sucesso.';
            }
            return $this->returnData($this->model->saveData($request), $message);
        } catch(\Exception $e) {
            return $this->returnError($e->getMessage());
        }
    }
    
    public function updateJson(Request $request)
    {
        try {
            $user = User::findOrFail($request->user_id);
            $user->filters = json_decode($request->json);
            $user->save();

            return $this->returnData($user, 'Json cadastrado com sucesso.');
        } catch (\Exception $e) {
            return $this->returnError($e->getMessage());
        }
    }
}