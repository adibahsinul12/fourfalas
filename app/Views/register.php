<?php

namespace App\Controllers;

class Auth extends BaseController
{
    // Tampilkan form login
    public function index()
    {
        if (session()->get('logged_in')) {
            $role = session()->get('role');
            return redirect()->to($role === 'Owner' ? '/owner' : '/admin');
        }
        return view('login');
    }

    // Proses login (POST)
    public function login()
    {
        $session  = session();
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // 1. JALUR CADANGAN MANUAL (Bypass Langsung Tanpa Cek Database)
        if ($username === 'admin' && $password === 'admin123') {
            $sessionData = [
                'id'        => 1,
                'username'  => 'admin',
                'role'      => 'Admin',
                'logged_in' => true
            ];
            $session->set($sessionData);
            return redirect()->to('/admin');
        }

        // 2. JALUR UTAMA DATABASE
        try {
            $db = \Config\Database::connect();
            $builder = $db->table('admins');
            $admin = $builder->getWhere(['username' => $username])->getRowArray();

            if ($admin) {
                $db_password = $admin['password'] ?? ($admin['password_hash'] ?? '');

                if ($password === $db_password || password_verify($password, $db_password)) {
                    $sessionData = [
                        'id'        => $admin['id'] ?? 1,
                        'username'  => $admin['username'],
                        'role'      => $admin['role'] ?? 'Admin',
                        'logged_in' => true
                    ];
                    $session->set($sessionData);

                    // Redirect sesuai role
                    if ($sessionData['role'] === 'Owner') {
                        return redirect()->to('/owner');
                    }

                    return redirect()->to('/admin');
                }
            }
        } catch (\Exception $e) {
            // Jika database error/tidak connect, biarkan sistem lanjut ke bawah
        }

        // Jika semua jalur di atas gagal
        $session->setFlashdata('msg', 'Username atau Password Salah!');
        return redirect()->to('/login');
    }

    // Tampilkan form register
    public function register()
    {
        return view('register');
    }

    // Proses register (POST)
    public function store()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $confirm  = $this->request->getPost('confirm_password');
        $role     = $this->request->getPost('role');

        if ($password !== $confirm) {
            session()->setFlashdata('msg', 'Konfirmasi password tidak cocok!');
            return redirect()->to('/register');
        }

        if (empty($role)) {
            session()->setFlashdata('msg', 'Silakan pilih role terlebih dahulu!');
            return redirect()->to('/register');
        }

        $db = \Config\Database::connect();
        $builder = $db->table('admins');

        $exists = $builder->getWhere(['username' => $username])->getRowArray();
        if ($exists) {
            session()->setFlashdata('msg', 'Username sudah digunakan!');
            return redirect()->to('/register');
        }

        $builder->insert([
            'username'      => $username,
            'password_hash' => password_hash($password, PASSWORD_DEFAULT),
            'role'          => $role, // Owner atau Admin, sesuai pilihan form
        ]);

        session()->setFlashdata('msg', 'Registrasi berhasil, silakan login!');
        return redirect()->to('/login');
    }

    // Logout
    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/login');
    }
}