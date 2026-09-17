<?php

namespace App\Controllers;

class AdminDashboard extends BaseController
{
    public function index()
    {
        if ($r = $this->mustAdmin()) {
            return $r;
        }

        $db = db_connect();

        $stats = [
            'users' => $db->table('users')->countAllResults(),

            'active_users' => $db
                ->table('users')
                ->where('is_active', 1)
                ->countAllResults(),
        ];

        return $this->render(
            'admin/dashboard',
            [
                'pageTitle' => 'Admin Dashboard',
                'stats' => $stats,
            ]
        );
    }
}