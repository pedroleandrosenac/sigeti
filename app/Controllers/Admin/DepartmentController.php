<?php

namespace App\Controllers\Admin;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Message;
use App\Core\Permission;
use App\Models\Department\Department;

class DepartmentController extends Controller
{
    public function __construct()
    {
        parent::__construct("App");

        Auth::requirePermission(Permission::VIEW_DEPARTMENTS);
    }

    public function index(): void
    {
        Auth::requirePermission(Permission::VIEW_DEPARTMENTS);
        
        $departmentModel = new Department();
        
        $departments = $departmentModel
            ->orderBy("name", "ASC")
            ->orderBy("deleted_at", "DESC")
            ->get();
        
        echo $this->view->render("admin/department/index", [
            "departments" => $departments
        ]);
        
        clear_old();
    }

    public function create(): void
    {
        Auth::requirePermission(Permission::CREATE_DEPARTMENT);
        
        echo $this->view->render("admin/department/create");
        
        clear_old();
    }

    public function ()
    {
        
    }
}