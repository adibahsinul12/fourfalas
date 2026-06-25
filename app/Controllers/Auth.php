<?php

namespace App\Controllers;

class Auth extends BaseController
{
    public function index()
    {
        // Jika sudah login, otomatis dialihkan ke halaman admin
        if (session()->get('logged_in')) {
            return redirect()->to('/admin');
        }
        return view('login');
    }

    public function login()
    {
        $session = session();
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Akun bawaan untuk uji coba login
        if ($username === 'admin' && $password === 'admin123') {
            $sessionData = [
                'username'  => $username,
                'logged_in' => true
            ];
            $session->set($sessionData);
            return redirect()->to('/admin');
        } else {
            $session->setFlashdata('msg', 'Username atau Password Salah!');
            return redirect()->to('/login');
        }
    }

    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to('/login');
    }
}