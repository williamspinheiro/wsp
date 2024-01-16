<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Repository
{
    protected $model;

    public function returnData($result, string $message = '', $isApi = false, $options = [])
    {
        if ($isApi == false) {
            return response()->json(['response' => $result, 'status' => 'success', 'message' => $message, 'options' => $options]);
        } else {
            return json_encode(['response' => $result, 'status' => 'success', 'options' => $options]);
        }
    }

    public function returnError(string $message, int $errorCode = 500, $isApi = false)
    {
        if ($isApi == false) {
            return response()->json(['response' => null, 'status' => 'error', 'message' => $message], $errorCode);
        } else {
            return json_encode(['response' => $message, 'status' => 'error']);
        }
    }

    public function returnDataTable($data, $objectModel, $classModel = null, $resourceClass = null, $permissionsCustom = [])
    {
        $column = $data['order'][0];
        $total = $objectModel->count();

        $objectModel = $objectModel->orderBy($data['columns'][$column['column']]['data'], $column['dir'])
                                    ->skip($data['start'])->take($data['length']);

        if (!$resourceClass) {
            $objectModel = $objectModel->selectRaw($this->getSelect($data['columns']))->get();
        } else {
            $objectModel = $resourceClass::collection($objectModel->get());
        }

        return $this->responseDatatable($objectModel, $classModel, $total, $permissionsCustom);
    }

    public function responseDatatable($data, $classModel, $total, $permissionsCustom = [])
    {
        $response = [
            "recordsTotal" => $total,
            "recordsFiltered" => $total,
            "data" => $data,
            "permissions" => $this->getPermissions($classModel, Auth::user(), $permissionsCustom),
        ];

        return response()->json($response);
    }

    public function getPermissions($classModel, User $user, $permissionsCustom = [])
    {
        $permissions =  [
                        'edit' => $user->can('edit', $classModel),
                        'delete' => $user->can('destroy', $classModel),
                        'active' => $user->can('active', $classModel),
                    ];

        return array_merge($permissions, $permissionsCustom);
    }

    private function getSelect(array $columns)
    {
        $response = [];

        foreach ($columns as $column) {
            $response[] = $column['data'];
        }

        return implode(',', $response);
    }

    public function updateActive(Request $request)
    {
        try {
            $model = $this->model->findOrFail($request->id);
            $model->active = $request->active;
            $model->save();
        } catch(\Exception $e) {
            return false;
        }

        return true;
    }
}