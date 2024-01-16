<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProfilePolicy extends Policy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
        return parent::validate($user, 'grupo-de-acessos-menu');
    }

    public function create(User $user)
    {
        return parent::validate($user, 'grupo-de-acessos-cadastrar');
    }

    public function edit(User $user)
    {
        return parent::validate($user, 'grupo-de-acessos-editar');
    }

    public function store(User $user)
    {
        return parent::validate($user, 'grupo-de-acessos-cadastrar')
        || parent::validate($user, 'grupo-de-acessos-editar');
    }

    public function active(User $user)
    {
        return parent::validate($user, 'grupo-de-acessos-ativar');
    }

    public function destroy(User $user)
    {
        return parent::validate($user, 'grupo-de-acessos-excluir');
    }
}
