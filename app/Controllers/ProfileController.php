<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Permission;
use App\Models\User;

class ProfileController extends Controller
{
    public function __construct()
    {
        parent::__construct('App');

        Auth::requirePermission(Permission::EDIT_OWN_PROFILE);
    }

    public function index(): void
    {
        $user = User::find(Auth::user()->id);


        $layout = $this->resolveLayout();

        echo $this->view->render('account/profile', [
            'user' => $user,
            'layout' => $layout
        ]);

        clear_old();
    }

    private function resolveLayout(): string
    {

        if (Auth::hasPermission(Permission::VIEW_MANAGER_DASHBOARD)) {
            return 'admin/app';
        }
        if (Auth::hasPermission(Permission::VIEW_TECHNICIAN_DASHBOARD)) {
            return 'technician/app';
        }
        if (Auth::hasPermission(Permission::VIEW_REQUESTER_DASHBOARD)) {
            return 'teacher/app';
        }
        return '/entrar';
    }

}