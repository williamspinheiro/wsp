<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy extends Policy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
        return parent::validate($user, 'usuarios-menu');
    }

    public function create(User $user)
    {
        return parent::validate($user, 'usuarios-cadastrar');
    }

    public function edit(User $user)
    {
        return parent::validate($user, 'usuarios-editar');
    }

    public function store(User $user)
    {
        return parent::validate($user, 'usuarios-cadastrar')
        || parent::validate($user, 'usuarios-editar');;
    }

    public function active(User $user)
    {
        return parent::validate($user, 'usuarios-ativar');
    }
    
    public function destroy(User $user)
    {
        return parent::validate($user, 'usuarios-excluir');
    }
}
