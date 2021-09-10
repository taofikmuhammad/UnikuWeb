<?php

namespace App\Controllers;

class Warga extends BaseController
{
    protected $model;
    protected $db;
    public function __construct()
    {
        $this->model = new \App\Models\WargaModel();
        $this->db = \Config\Database::connect();

    }
    public function index()
    {
        $data = [
            'title' => 'Data Warga',
            'warga' => $this->db->table('warga')->get()->getResult(),
            'rt'    => $this->db->table('rt')->get()->getResult(),
            'rw'    => $this->db->table('rw')->get()->getResult(),
        ];
        return view('warga/index', $data);
    }

    public function listWarga()
    {
        $list = $this->model->get_datatables();

        $data = [];
        $no = $this->request->getPost('start');
        foreach ($list as $x) {
            $no++;
            $row    = array();
            $row[]  = $no;
            $row[]  = $x->nik;
            $row[]  = $x->nama_lengkap ;
            $row[]  = $x->tempat_lahir;
            $row[]  = $x->tanggal_lahir;
            $row[]  = $x->alamat;
            $row[]  = $this->_btn($x);
            $data[] = $row;
        }

        $output = [
            'draw'  => $_POST['draw'],
            'data'  => $data,
            'recordsTotal'  => $this->model->count_all(),
            'recordsFiltered'  => $this->model->count_filtered(),
        ];
        $csrf_name = csrf_token();
        $csrf_hash = csrf_hash();
        $output[$csrf_name] = $csrf_hash;
        echo json_encode($output);
    }
    private function _btn($x)
    {
        $btn = '<a href="' . base_url('warga/' . $x->nik . '/edit') . '" class="btn btn-success btn-sm">Edit</a>';
        $btn .= '<form method="post" class="d-inline ml-2" action="' . base_url('warga/' . $x->nik) . '">';
        $btn .= csrf_field();
        $btn .= '<input type="hidden" name="_method" value="DELETE">';
        $btn .= '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(' . "'data ini akan di hapus ?'" . ')">Hapus</button>';
        $btn .= '</form>';
        return $btn;
    }

    public function new()
    {
        $data = [
            'title'         => 'Add Warga',
            'validation'    => $this->validasi,
            'rt'            => $this->db->table('rt')->get()->getResult(),
            'kecamatan'     => $this->db->table('kecamatan')->get()->getResult(),
        ];
        return view('warga/add', $data);
    }

    public function create()
    {
        $ps = $this->request->getVar();
        $rules = [
            'nik'           => 'required|numeric|is_unique[warga.nik]',
            'nama_lengkap'  => 'required',
            'tempat_lahir'  => 'required',
            'tanggal_lahir' => 'required',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput();
        }
        $data = [
            'nik'               => $ps['nik'],
            'password'          => password_hash($ps['password'], PASSWORD_DEFAULT),
            'nama_lengkap'      => $ps['nama_lengkap'],
            'tempat_lahir'      => $ps['tempat_lahir'],
            'tanggal_lahir'     => $ps['tanggal_lahir'],
            'alamat'            => $ps['alamat'],
            'warganegara'       => $ps['warganegara'],
            'golongan_darah'    => $ps['golongan_darah'],
            'agama'             => $ps['agama'],
            'status'            => 1,
            'no_rt'             => $ps['no_rt'],
            'id_kecamatan'      => $ps['id_kecamatan'],
        ];

        $this->db->table('warga')->insert($data);
        session()->setFlashdata('pesan', 'Berhasil disimpan');
        return redirect()->to('/warga');

    }

    public function delete($id)
    {
        $employee = $this->model->find($id);
        $ttd = $this->db->table('warga')->where('nik', $id)->get()->getRow();
       
        $this->model->delete($id);
        session()->setFlashdata('pesan', 'Data berhasil di hapus');
        return redirect()->to('/warga');
    }

    public function edit($id)
    {
        $data = [
            'judul'         => 'Upadate Data Warga',
            'validation'    => $this->validasi,
            'rt'            => $this->db->table('rt')->get()->getResult(),
            'kecamatan'     => $this->db->table('kecamatan')->get()->getResult(),
            'detail'        => $this->db->table('warga')->where('nik', $id)->get()->getRow(),
            'detail_warga'  => $this->db->table('warga')->where('nik', $id)->get()->getRowArray(),
        ];
        return view('warga/edit', $data);
    }

    public function update($id)
    {
        $ps = $this->request->getVar();

        $wrg = $this->db->table('warga')->where('nik', $id)->get()->getRow();

        $rules = [
            // 'nik'           => 'required|numeric|is_unique[warga.nik]',
            'nama_lengkap'  => 'required',
            'tempat_lahir'  => 'required',
            'tanggal_lahir' => 'required',
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput();
        }

        if($ps['password'] != ""){
            $data = [
                'password'          => password_hash($ps['password'], PASSWORD_DEFAULT),
            ];
        }

        $data = [
            'nama_lengkap'      => $ps['nama_lengkap'],
            'tempat_lahir'      => $ps['tempat_lahir'],
            'tanggal_lahir'     => $ps['tanggal_lahir'],
            'alamat'            => $ps['alamat'],
            'warganegara'       => $ps['warganegara'],
            'golongan_darah'    => $ps['golongan_darah'],
            'agama'             => $ps['agama'],
            'status'            => 1,
            'no_rt'             => $ps['no_rt'],
            'id_kecamatan'      => $ps['id_kecamatan'],
        ];

        $this->db->table('warga')->where('nik', $id)->update($data);
        session()->setFlashdata('pesan', 'Data berhasil diupdate');
        return redirect()->to('/warga');

    }

}