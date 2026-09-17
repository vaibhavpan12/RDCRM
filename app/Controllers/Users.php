<?php

namespace App\Controllers;

use App\Models\UserModel;

class Users extends BaseController
{
    public function index()
    {
        if ($r = $this->mustAdmin()) {
            return $r;
        }

        $rows = (new UserModel())
            ->orderBy('id', 'DESC')
            ->findAll();

        return $this->render(
            'users/index',
            [
                'pageTitle' => 'Users',
                'rows' => $rows,
            ]
        );
    }

    public function create()
    {
        if ($r = $this->mustAdmin()) {
            return $r;
        }

        $name = trim((string) $this->request->getPost('name'));
        $email = strtolower(trim((string) $this->request->getPost('email')));
        $password = (string) $this->request->getPost('password');
        $role = (string) $this->request->getPost('role');

        if (!in_array($role, ['admin', 'user'], true)) {
            $role = 'user';
        }

        if ($name === '' || $email === '' || $password === '') {
            return redirect()
                ->back()
                ->with('error', 'All fields are required.');
        }

        $model = new UserModel();

        if ($model->where('email', $email)->first()) {
            return redirect()
                ->back()
                ->with('error', 'Email already exists.');
        }

        $model->insert([
            'name' => $name,
            'email' => $email,
            'password_hash' => password_hash(
                $password,
                PASSWORD_DEFAULT
            ),
            'role' => $role,
            'is_active' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()
            ->back()
            ->with('success', 'User created successfully.');
    }

    public function toggle($id)
    {
        if ($r = $this->mustAdmin()) {
            return $r;
        }

        $model = new UserModel();

        $user = $model->find($id);

        // Admin cannot disable himself
        if ($user && $user['id'] != session()->get('user')['id']) {
            $model->update(
                $id,
                [
                    'is_active' => $user['is_active'] ? 0 : 1,
                    'updated_at' => date('Y-m-d H:i:s'),
                ]
            );
        }

        return redirect()->back();
    }
}
