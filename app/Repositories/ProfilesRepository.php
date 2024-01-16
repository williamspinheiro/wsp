<?php

namespace App\Repositories;

use App\Http\Controllers\ProfileController;
use App\Models\Profile;
use Illuminate\Http\Request;
use App\Repositories\PermissionsRepository;

class ProfilesRepository extends Repository
{
    protected $profile;

    public function __construct(Profile $profile)
    {
        $this->model = $profile;
    }

    public function getList(Request $request)
    {
        return $this->model->query()
                            ->withFilter($request);
    }

    public function getListByName(string $name)
    {
        return $this->model->query()
                            ->byName($name)
                            ->select('id', 'name')
                            ->get();
    }

    public function saveData(Request $request, PermissionsRepository $permissions)
    {
        try {
            return \DB::transaction(function () use ($request, $permissions) {
                    
                $profileInserted = $this->model->saveData($request);
                
                $permissions->saveData($request, $profileInserted->id);

                if ($request->has('id')) {
                    $message = 'Grupo de Acessos alterado com sucesso.';
                    $options = ['redirect_to' => action([\App\Http\Controllers\ProfileController::class, 'edit'], $profileInserted->id)];
                } else {
                    $message = 'Grupo de Acessos cadastrado com sucesso.';
                    $options = ['redirect' => action([\App\Http\Controllers\ProfileController::class, 'edit'], $profileInserted->id)];
                }
                
                return $this->returnData($profileInserted, $message, false, $options);
            });
        } catch (\Exception $e) {
            return $this->returnError($e->getMessage());
        }
    }

    public function updateJson(Request $request)
    {
        try {
            $profile = Profile::findOrFail($request->profile_id);
            $profile->filters = json_decode($request->json);
            $profile->save();

            return $this->returnData($profile, 'Json cadastrado com sucesso.');
        } catch (\Exception $e) {
            return $this->returnError($e->getMessage());
        }
    }
}
