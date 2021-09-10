<?php

namespace App\Controllers;

class AuthController extends BaseController
{
    protected $model;
    public function __construct()
    {
        $this->model = new \App\Models\AuthModel();
    }
    public function login()
    {
        $data = [
            'validation' => $this->validasi,
        ];
        return view('auth/login', $data);
    }
    public function prosesLogin()
    {
        $p = $this->request->getVar();
        $rules = [
            'nik' => 'required',
            'password' => 'required',
        ];
        if (!$this->validate($rules)) {
            return $this->login();
        }
        $user = $this->model->where('nik', $p['nik'])->first();
        if ($user) {
            if (password_verify($p['password'], $user['password'])) {
                $sesdata = [
                    'nik' => $user['nik'],
                    'nama' => $user['nama_lengkap'],
                ];
                session()->set($sesdata);
                return redirect()->to('/');
            } else {
                session()->setFlashdata('eror', 'nik/password tidak ditemukan');
                return redirect()->to('/auth');
            }
        } else {
            session()->setFlashdata('eror', 'nik/password tidak ditemukan');
            return redirect()->to('/auth');
        }
    }
    
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/auth');
    }
}
