<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class Permission extends Model
{
    use HasFactory;

    public function scopeIsActive($query)
    {
        return $query->where('active', true);
    }

    public function saveData(Request $request): Permission
    {
        if ($request->has('id')) {
            $permission = Permission::findOrFail($request->id);
        } else {
            $permission = new Permission;
        }

        $permission->name = $request->name;
        $permission->alias = Str::slug($request->name);
        $permission->save();

        return $permission;
    }
}
