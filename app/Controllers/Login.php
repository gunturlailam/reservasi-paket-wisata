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

        if (empty($email) || empty($password)) {
            $session->setFlashdata('error', 'Email dan password wajib diisi.');
            return redirect()->to('login');
        }

        $userModel = new \App\Models\UserModel();
        $user = null;

        // Auto-detect user dari semua tabel
        // 1. Cek di tabel pemilik
        $user = $userModel->findPemilikByEmail($email);

        // 2. Jika tidak ada, cek di tabel penyewa
        if (!$user) {
            $user = $userModel->findPenyewaByEmail($email);
        }

        // 3. Jika tidak ada, cek di tabel karyawan untuk admin
        if (!$user) {
            $user = $userModel->findAdminByEmail($email);
        }

        // 4. Jika tidak ada, cek di tabel karyawan untuk supir
        if (!$user) {
            $user = $userModel->findSupirByEmail($email);
        }

        // 5. Jika tidak ada, cek di tabel karyawan biasa
        if (!$user) {
            $user = $userModel->findKaryawanByEmail($email);
        }

        if (!$user) {
            $session->setFlashdata('error', 'Email tidak ditemukan.');
            return redirect()->to('login');
        }

        if (!$userModel->verifyPassword($user['password'], $password)) {
            $session->setFlashdata('error', 'Password salah.');
            return redirect()->to('login');
        }

        // Set session dengan role dari database
        $session->set([
            'user_id' => $user['id'],
            'user_name' => $user['name'] ?? 'User',
            'user_email' => $user['email'],
            'user_role' => $user['role'], // Role otomatis dari database
            'user_foto' => $user['foto'] ?? null,
            'isLoggedIn' => true
        ]);

        // Redirect ke dashboard
        return redirect()->to('/dashboard');
    }

    public function dashboard()
    {
        $session = session();

        // Cek apakah user sudah login
        if (!$session->get('isLoggedIn')) {
            return redirect()->to('/login');
        }

        // Ambil statistik dari database
        $db = \Config\Database::connect();

        $totalPenyewa = $db->table('penyewa')->countAllResults();
        $totalBus = $db->table('bus')->countAllResults();
        $totalPaketWisata = $db->table('paket_wisata')->countAllResults();
        $totalPemesanan = $db->table('pemesanan')->countAllResults();

        // Array quotes motivasi
        $quotes = [
            ['text' => 'Kesuksesan adalah hasil dari persiapan, kerja keras, dan belajar dari kegagalan.', 'author' => 'Colin Powell'],
            ['text' => 'Jangan menunggu kesempatan, ciptakanlah kesempatan itu.', 'author' => 'George Bernard Shaw'],
            ['text' => 'Cara terbaik untuk memprediksi masa depan adalah dengan menciptakannya.', 'author' => 'Peter Drucker'],
            ['text' => 'Kesuksesan bukanlah kunci kebahagiaan. Kebahagiaan adalah kunci kesuksesan.', 'author' => 'Albert Schweitzer'],
            ['text' => 'Mulailah dari mana kamu berada, gunakan apa yang kamu punya, lakukan apa yang kamu bisa.', 'author' => 'Arthur Ashe'],
            ['text' => 'Mimpi besar, bekerja keras, tetap fokus, dan kelilingi dirimu dengan orang-orang baik.', 'author' => 'Unknown'],
            ['text' => 'Kegagalan adalah kesempatan untuk memulai lagi dengan lebih cerdas.', 'author' => 'Henry Ford'],
            ['text' => 'Perjalanan seribu mil dimulai dengan satu langkah.', 'author' => 'Lao Tzu']
        ];

        // Array fun facts keren
        $funFacts = [
            ['icon' => '🚀', 'text' => 'Tahukah kamu? Industri pariwisata Indonesia menyumbang 5.5% dari PDB nasional!'],
            ['icon' => '🌍', 'text' => 'Fun Fact: Indonesia memiliki lebih dari 17.000 pulau yang bisa dijelajahi!'],
            ['icon' => '🎯', 'text' => 'Wow! Rata-rata orang menghabiskan 13 hari per tahun untuk merencanakan liburan.'],
            ['icon' => '✈️', 'text' => 'Menarik! Wisatawan yang merencanakan perjalanan lebih bahagia 8 minggu sebelum berangkat.'],
            ['icon' => '🏖️', 'text' => 'Tahukah kamu? Berlibur dapat meningkatkan produktivitas hingga 40%!'],
            ['icon' => '🚌', 'text' => 'Fun Fact: Bus wisata pertama di dunia dimulai di Inggris tahun 1825!'],
            ['icon' => '🎉', 'text' => 'Wow! 80% orang merasa lebih kreatif setelah berlibur.'],
            ['icon' => '💡', 'text' => 'Menarik! Traveling dapat meningkatkan kemampuan problem solving hingga 50%!'],
            ['icon' => '🌟', 'text' => 'Tahukah kamu? Orang yang sering traveling memiliki risiko penyakit jantung 30% lebih rendah.'],
            ['icon' => '🎨', 'text' => 'Fun Fact: Mengunjungi tempat baru dapat meningkatkan kreativitas dan inovasi!']
        ];

        // Pilih quote dan fun fact random
        $randomQuote = $quotes[array_rand($quotes)];
        $randomFunFact = $funFacts[array_rand($funFacts)];

        $data = [
            'user_name' => $session->get('user_name'),
            'user_role' => $session->get('user_role'),
            'user_email' => $session->get('user_email'),
            'user_foto' => $session->get('user_foto'),
            'total_penyewa' => $totalPenyewa,
            'total_bus' => $totalBus,
            'total_paket_wisata' => $totalPaketWisata,
            'total_pemesanan' => $totalPemesanan,
            'quote' => $randomQuote,
            'funFact' => $randomFunFact
        ];

        return view('dashboard', $data);
    }

    public function logout()
    {
        $session = session();
        $session->destroy();

        // Redirect kembali ke halaman login
        return redirect()->to(site_url('login'));
    }
}
