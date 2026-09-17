<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        if (session()->get('logged_in')) {

            $user = session()->get('user');

            if (($user['role'] ?? null) === 'admin') {
                return redirect()->to(base_url('admin/dashboard'));
            }

            return redirect()->to(base_url('dashboard'));
        }

        return view('auth/login');
    }

    public function attempt()
    {
        $email = strtolower(trim((string) $this->request->getPost('email')));
        $password = (string) $this->request->getPost('password');

        $model = new UserModel();

        $user = $model
            ->where('email', $email)
            ->first();

        /*
        |--------------------------------------------------------------------------
        | Validate Login
        |--------------------------------------------------------------------------
        */

        if (
            !$user ||
            !$user['is_active'] ||
            !password_verify($password, $user['password_hash'])
        ) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Invalid email or password.');
        }

        /*
        |--------------------------------------------------------------------------
        | Regenerate Session
        |--------------------------------------------------------------------------
        */

        session()->regenerate();

        session()->set([
            'logged_in' => true,

            'user' => [
                'id'    => $user['id'],
                'name'  => $user['name'],
                'email' => $user['email'],
                'role'  => $user['role'],
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Role Based Redirect
        |--------------------------------------------------------------------------
        */

        if ($user['role'] === 'admin') {
            return redirect()->to(base_url('admin/dashboard'));
        }

        return redirect()->to(base_url('dashboard'));
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to(base_url('login'));
    }
}