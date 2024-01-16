<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'filters' => 'array',
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function profile()
    {
        return $this->hasOne(Profile::class, 'id', 'profile_id');
    }

    public function scopeWithFilter($query, Request $request)
    {
        if ($request->filled('id')) {
            $query->byId($request->id);
        }

        if ($request->filled('name')) {
            $query->byName($request->name);
        }

        if ($request->filled('profile_id')) {
            $query->byProfile($request->profile_id);
        }

        if ($request->filled('email')) {
            $query->byEmail($request->email);
        }

        if ($request->filled('active')) {
            $query->active($request->active);
        }

        return $query;
    }

    public function scopeById($query, int $userId)
    {
        return $query->where('id', $userId);
    }

    public function scopeByName($query, string $userName)
    {
        return $query->where('alias', 'LIKE', '%'. Str::slug($userName) .'%');
    }

    public function scopeByProfile($query, int $profileId)
    {
        return $query->where('profile_id', $profileId);
    }

    public function scopeByEmail($query, string $email)
    {
        return $query->where('email', 'LIKE', '%'. $email .'%');
    }

    public function scopeActive($query, $isActive = true)
    {
        return $query->where('active', $isActive);
    }

    public function getPermissionsList(User $user): array
    {
        $request = request();

        try {
            if ($request->session()->exists('permissions') == false) {
                $permissionsAlias = optional($user->profile)->permissions()->pluck('alias')->toArray();
                $request->session()->put('permissions', $permissionsAlias);
                return $permissionsAlias;
            } else {
                return $request->session()->get('permissions');
            }
        } catch(\Exception $e) {
            return optional($user->profile)->permissions()->pluck('alias')->toArray();
        }
    }

    public function saveData(Request $request, array $photo): User
    {
        if ($request->has('id')) {
            $user = User::FindOrFail($request->id);
        } else {
            $user = new User;
        }

        $user->profile_id = $request->profile_id;
        $user->name = $request->name;
        $user->alias = Str::slug($request->name);
        $user->email = $request->email;
        $user->password_temporary = $request->password_temporary ?? false;
        $user->active = $request->active ?? false;

        if (empty($photo['basename']) == false) {          
            $user->photo = $photo['basename'];
        }

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return $user;
    }
}
