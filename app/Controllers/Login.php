<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Login extends BaseController
{
    public function index()
    {
        helper(['form']);
        echo view('login_view');
    }

    public function authenticate()
    {
        helper(['form']);
        $session = session();
        $request = service('request');

        $email = $request->getPost('email');
        $password = $request->getPost('password');
        $role = $request->getPost('role');

        if (empty($email) || empty($password) || empty($role)) {
            $session->setFlashdata('error', 'Email, password, dan role wajib diisi.');
            return redirect()->to('login');
        }

        $userModel = new \App\Models\UserModel();
        $user = null;

        if ($role == 'karyawan') {
            $user = $userModel->findKaryawanByEmail($email);
        } elseif ($role == 'penyewa') {
            $user = $userModel->findPenyewaByEmail($email);
        }

        if (!$user) {
            $session->setFlashdata('error', 'Email tidak ditemukan untuk role tersebut.');
            return redirect()->to('login');
        }

        if (!$userModel->verifyPassword($user['password'], $password)) {
            $session->setFlashdata('error', 'Password salah.');
            return redirect()->to('login');
        }

        $session->set('user', $user);
        // Redirect ke halaman utama (main.php)
        return redirect()->to('login/dashboard');
    }

    public function dashboard()
    {
        $session = session();
        $user = $session->get('user');
        return view('dashboard', ['user' => $user]);
    }

    public function logout()
    {
        $session = session();
        $session->destroy();

        // Redirect kembali ke halaman login
        return redirect()->to(site_url('login'));
    }
}
