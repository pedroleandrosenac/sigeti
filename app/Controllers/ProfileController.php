<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Permission;

class ProfileController extends Controller
{
    public function __construct()
    {
        parent::__construct('App');
        Auth::requirePermission(Permission::EDIT_OWN_PROFILE);
    }

    private function resolveLayout(): string
    {

        if (Auth::hasPermission(Permission::VIEW_MANAGER_DASHBOARD)) {
            return 'admin/app';
        }
        if (Auth::hasPermission(Permission::VIEW_TECHNICIAN_DASHBOARD)) {
            return 'technician/app';
        }
        if (Auth::hasPermission(Permission::VIEW_REQUESTER_DASHBOARD)){
            return 'teacher/app';
        }
        return '/entrar';
    }

}