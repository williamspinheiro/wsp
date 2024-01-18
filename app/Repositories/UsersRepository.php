<?php

namespace App\Repositories;

use App\Helpers\UploadHelper;
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
            return \DB::transaction(function () use ($request) {

                $photo = $this->savePhoto($request);
                
                $userInserted = $this->model->saveData($request, $photo);
                
                if ($request->has('id')) {
                    $message = 'Usuário alterado com sucesso.';
                    $options = ['redirect_to' => action([\App\Http\Controllers\UserController::class, 'edit'], $userInserted->id)];
                } else {
                    $message = 'Usuário cadastrado com sucesso.';
                    $options = ['redirect' => action([\App\Http\Controllers\UserController::class, 'edit'], $userInserted->id)];
                }
                
                return $this->returnData($userInserted, $message, false, $options);
            });
        } catch(\Exception $e) {
            return $this->returnError($e->getMessage());
        }
    }

    public function saveProfile(Request $request)
    {
        try {
            return \DB::transaction(function () use ($request) {

                $photo = $this->savePhoto($request);

                $request->merge([
                    'password_temporary' => false,
                ]);
                
                $userUpdated = $this->model->saveData($request, $photo);
                
                $message = 'Dados pessoais editados com sucesso!';
                $options = ['redirect' => action([\App\Http\Controllers\UserController::class, 'profile'], $userUpdated->id)];
                
                return $this->returnData($userUpdated, $message, false, $options);
            });
        } catch(\Exception $e) {
            return $this->returnError($e->getMessage());
        }
    }

    public function savePhoto(Request $request)
    {
        $photo = [];
                
        if ($request->file('photo') == true) {
            UploadHelper::setDisk('public')
                        ->setFile($request->photo)
                        ->setPath('photo-user')
                        ->save()
                        ->resize(500, 500);

            $photo = UploadHelper::getInfoFile('with-url');
        }

        return $photo;
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