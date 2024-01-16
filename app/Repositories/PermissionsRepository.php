<?php

namespace App\Repositories;

use App\Models\Permission;
use App\Models\ProfilePermission;
use Illuminate\Http\Request;

class PermissionsRepository extends Repository
{
    private $permission;

    public function __construct(Permission $permission)
    {
        $this->permission = $permission;
    }

    public function getList()
    {
        return $this->permission->query()->get();
    }

    public function saveData(Request $request, int $profileId)
    {
        ProfilePermission::removeByProfileId($profileId);

        if ($request->has('permission_ids')) {
            foreach ($request->permission_ids as $permissionId) {
                ProfilePermission::saveData($permissionId, $profileId);
            }
        }
    }
}