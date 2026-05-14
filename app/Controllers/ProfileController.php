<?php

namespace App\Controllers;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Message;
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
            'layout' => $layout,
            'profile' => null
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

    public function update(?array $data): void
    {
        //$this->validateCsrfToken($data, "/perfil");

        $user = User::find(Auth::user()->id);

        if (!$user) {
            Message::error("Usúario não encontrado");
            redirect("/perfil");
            return;
        }

        try {

            $user->fill([
                "avatar_path" => "",
                "phone" => $data["phone"],
                "extension" => $data["extension"],
                "gender" => $data["gender"],
                "birth_date" => $data["birth_date"],
                "job_title" => $data["job_title"],
                "registration" => $data["registration"],
                "specialty" => $data["specialty"],
                "bio" => $data["bio"],
                "city" => $data["city"],
                "country" => $data["country"],
            ]);

            $errors = array_merge(
                $user->validate($data),
            );

            if ($errors) {

                flash_old($data);

                foreach ($errors as $error) {
                    Message::warning($error);
                }
                redirect("/perfil");
            }

            $user->save();

        } catch (\InvalidArgumentException $invalidArgumentException) {
            Message::error($invalidArgumentException->getMessage());
            redirect("/perfil");
            return;
        }

        Message::success("Perfil atualizado com sucesso!");
        redirect("/perfil");

    }

}