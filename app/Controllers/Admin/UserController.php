<?php

namespace App\Controllers\Admin;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Permission;
use App\Models\User;

class UserController extends Controller
{
    public function __construct()
    {
        parent::__construct("App");
        Auth::requirePermission(Permission::VIEW_USERS);
    }

    public function index(): void
    {
        Auth::requirePermission(Permission::VIEW_USERS);

        $users = (new User())
            ->orderBy("name")
            ->orderBy("created_at", "DESC")
            ->get();

        echo $this->view->render("admin/user/index", [
            "users" => $users
        ]);

        clear_old();
    }

}