<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfilePermission extends Model
{
    use HasFactory;

    public $timestamps = false;
    
    public static function saveData(int $permissionId, int $profileId): ProfilePermission
    {
        $profilePermission = new ProfilePermission;
        $profilePermission->permission_id = $permissionId;
        $profilePermission->profile_id = $profileId;
        $profilePermission->save();

        return $profilePermission;
    }

    public static function removeByProfileId(int $profileId)
    {
        ProfilePermission::where('profile_id', $profileId)->delete();
    }
}
