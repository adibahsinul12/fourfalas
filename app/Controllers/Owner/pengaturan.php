<?php

namespace App\Controllers\Owner;

use App\Controllers\BaseController;
use App\Models\SettingsModel;
use App\Models\AdminModel;

class Pengaturan extends BaseController
{
    public function index()
    {
        $settingsModel = new SettingsModel();

        $data = [
            'settings' => $settingsModel->getSettings(),
        ];

        return view('owner/pengaturan', $data);
    }

    public function updateSettings()
    {
        $settingsModel = new SettingsModel();

        $rules = [
            'cafe_name'             => 'required|max_length[255]',
            'operating_hours_open'  => 'required',
            'operating_hours_close' => 'required',
            'service_tax_percent'   => 'permit_empty|decimal',
            'contact_info'          => 'permit_empty|max_length[255]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'cafe_name'             => $this->request->getPost('cafe_name'),
            'operating_hours_open'  => $this->request->getPost('operating_hours_open'),
            'operating_hours_close' => $this->request->getPost('operating_hours_close'),
            'service_tax_percent'   => $this->request->getPost('service_tax_percent') ?: 0,
            'contact_info'          => $this->request->getPost('contact_info'),
        ];

        // Upload logo baru kalau ada file yang dikirim
        $file = $this->request->getFile('logo');
        if ($file && $file->isValid() && ! $file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/logo', $newName);
            $data['logo_path'] = 'uploads/logo/' . $newName;
        }

        $settingsModel->saveSettings($data);

        return redirect()->to('owner/pengaturan')->with('msg', 'Pengaturan cafe berhasil disimpan.');
    }

    public function updatePassword()
    {
        $rules = [
            'password_lama'      => 'required',
            'password_baru'      => 'required|min_length[6]',
            'password_konfirmasi'=> 'required|matches[password_baru]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        $adminModel = new AdminModel();
        $username   = session()->get('username');
        $admin      = $adminModel->where('username', $username)->first();

        if (! $admin || ! password_verify($this->request->getPost('password_lama'), $admin['password_hash'])) {
            return redirect()->back()->with('msg_error', 'Password lama yang kamu masukkan salah.');
        }

        $adminModel->update($admin['id'], [
            'password_hash' => password_hash($this->request->getPost('password_baru'), PASSWORD_DEFAULT),
        ]);

        return redirect()->to('owner/pengaturan')->with('msg', 'Password berhasil diubah.');
    }
}