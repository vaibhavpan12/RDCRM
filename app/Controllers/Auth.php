<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    public function login()
    {
        if (session()->get('logged_in')) return redirect()->to(base_url('dashboard'));
        return view('auth/login');
    }
    public function attempt()
    {
        $email = strtolower(trim((string)$this->request->getPost('email')));
        $pass = (string)$this->request->getPost('password');
        $u = (new UserModel())->where('email', $email)->first();
        if (!$u || !$u['is_active'] || !password_verify($pass, $u['password_hash'])) return redirect()->back()->with('error', 'Invalid email or password.');
        session()->regenerate();
        session()->set(['logged_in' => true, 'user' => ['id' => $u['id'], 'name' => $u['name'], 'email' => $u['email'], 'role' => $u['role']]]);
        return redirect()->to(base_url('dashboard'));
    }
    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('login'));
    }
}
