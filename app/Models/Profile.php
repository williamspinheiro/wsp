<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class Profile extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $casts = [
        'filters' => 'array',
    ];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'profile_permissions', 'profile_id', 'permission_id');
    }

    public function scopeWithFilter($query, Request $request)
    {
        if ($request->filled('id')) {
            $query->where('id', $request->id);
        }

        if ($request->filled('name')) {
            $query->where('alias', 'LIKE', '%'. Str::slug($request->name) .'%');
        }

        if ($request->filled('active')) {
            $query->active($request->active);
        }

        return $query;
    }

    public function scopeActive($query, $isActive)
    {
        return $query->where('active', $isActive);
    }

    public function scopeByName($query, string $name)
    {
        return $query->where('alias', 'LIKE', '%'. Str::slug($name) .'%');
    }

    public function saveData(Request $request): Profile
    {
        if ($request->has('id')) {
            $profile = Profile::findOrFail($request->id);
        } else {
            $profile = new Profile;
        }

        $profile->name = $request->name;
        $profile->alias = Str::slug($request->name);
        $profile->description = $request->description;
        $profile->active = $request->active ?? false;
        $profile->save();
        
        return $profile;
    }
}
