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

    public function store(?array $data): void
    {
        Auth::requirePermission(Permission::CREATE_DEPARTMENT);

        $this->validateCsrfToken($data, "/admin/departamentos/cadastrar");

        $department = new Department();

        try {
            $department->fill([
                "name" => $data["name"],
                "code" => $data["code"],
                "description" => $data["description"],
                "address" => $data["address"],
            ]);

            $errors = array_merge(
                $department->validate($data),
                $department->validateBusinessRule()
            );

            if ($errors){
                flash_old($data);

                foreach ($errors as $error){
                    Message::warning($error);
                }
                redirect("/admin/departamentos/cadastrar");
                return;
            }

            $department->save();
        }catch (\InvalidArgumentException $invalidArgumentException){
            Message::error($invalidArgumentException->getMessage());
            redirect("/admin/departamentos/cadastrar");
            return;
        }

        Message::success("Departamento cadastrado com sucesso!");
        redirect("/admin/departamentos");
    }

    public function edit(?array $data): void
    {
        Auth::requirePermission(Permission::EDIT_DEPARTMENT);

        $department = Department::find($data["id"]);

        if (!$department){
            Message::warning("Departamento não cadastrada ou não existe.");
            redirect("/admin/departamentos");
            return;
        }

        echo $this->view->render("admin/department/edit", [
            "department" => $department
        ]);

        clear_old();
    }

    public function update(?array $data): void
    {
        Auth::requirePermission(Permission::EDIT_DEPARTMENT);

        $this->validateCsrfToken($data, "/admin/departamentos/editar");

        $department = Department::find($data["id"]);
        if (!$department){
            Message::warning("Departamento não cadastrada ou não existe.");
            redirect("/admin/departamentos");
            return;
        }

        try {
            $department->fill([
                "name" => $data["name"],
                "code" => $data["code"],
                "description" => $data["description"],
                "address" => $data["address"],
            ]);
            $errors = array_merge(
                $department->validate($data),
                $department->validateBusinessRule($department->getId())
            );
            if ($errors){
                flash_old($data);
                foreach ($errors as $error){
                    Message::warning($error);
                }
                redirect("/admin/departamentos/editar" . $department->getId());
                return;
            }

            $department->save();
        }catch (\InvalidArgumentException $invalidArgumentException){
            Message::error($invalidArgumentException->getMessage());
            redirect("/admin/departamentos/editar" . $department->getId());
            return;
        }

        Message::success("Departamento editado com sucesso!");
        redirect("/admin/departamentos" . $department->getId());
    }
}