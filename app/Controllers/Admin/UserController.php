<?php

namespace App\Controllers\Admin;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Message;
use App\Core\Permission;
use App\Models\Role\Role;
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

    public function create(): void
    {
        Auth::requirePermission(Permission::CREATE_USER);

        $roles = Role::all();

        echo $this->view->render("admin/user/create", [
            "roles" => $roles
        ]);

        clear_old();

    }
    public function store(?array $data): void
    {
        Auth::requirePermission(Permission::CREATE_USER);

        $this->validateCsrfToken($data, "/admin/usuarios/cadastrar");

        $newUser = new User();

        try {

            $newUser->fill([
                "name" => $data["name"],
                "email" => $data["email"],
                "password" => $data["password"],
                "role_id" => $data["role_id"],
                "status" => $data["status"]
            ]);

            $errors = array_merge(
                $newUser->validate($data),
                $newUser->validateBusinessRule()
            );


            if ($errors) {

                flash_old($data);

                foreach ($errors as $error) {
                    Message::warning($error);
                }

                redirect("/admin/usuarios/cadastrar");
            }

            $newUser->save();



        } catch (\InvalidArgumentException $invalidArgumentException) {
            Message::error($invalidArgumentException->getMessage());
            redirect("/admin/usuarios/cadastrar");
            return;
        }

        Message::success("Usuário cadastrado com sucesso!");
        redirect("/admin/usuarios/editar/" . $newUser->getId());

    }
    }