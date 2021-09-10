<?php

namespace App\Models;

use CodeIgniter\Model;

class WargaModel extends Model
{
    protected $table      = 'warga';
    protected $primaryKey = 'nik';
    protected $allowedFields = [
        "nama_lengkap",
        "tempat_lahir",
        "tanggal_lahir",
        "alamat",
    ];
    protected $column_order = array('nik','nama_lengkap', 'tempat_lahir', 'tanggal_lahir','alamat', null);
    protected $column_search = array('nik','nama_lengkap', 'tempat_lahir', 'tanggal_lahir','alamat');
    protected $order = array('nik' => 'asc');
    protected $db;
    protected $dt;
    protected $request;

    function __construct()
    {
        parent::__construct();
        $this->db = db_connect();
        $this->request = \Config\Services::request();
        $this->dt = $this->db->table($this->table)->select('warga.*')->select('rw.no_rw as no_rw');
    }

    private function _get_datatables_query()
    {
        $this->dt->join('rt', 'rt.no_rt = warga.no_rt','left');
        $this->dt->join('rw', 'rw.no_rw = rt.no_rw','left');


        if ($this->request->getPost('cari') != '') {
            $this->dt->like('nik', $this->request->getPost('cari'));
            $this->dt->orLike('nama_lengkap', $this->request->getPost('cari'));
        }

        if ($this->request->getPost('rt') != '') {
            $this->dt->where('warga.no_rt', $this->request->getPost('rt'));
        }

        if ($this->request->getPost('rw') != '') {
            $this->dt->where('rw.no_rw', $this->request->getPost('rw'));
        }

        $i = 0;
        foreach ($this->column_search as $item) {
            if ($this->request->getPost('search')['value']) {
                if ($i === 0) {
                    $this->dt->groupStart();
                    $this->dt->like($item, $this->request->getPost('search')['value']);
                } else {
                    $this->dt->orLike($item, $this->request->getPost('search')['value']);
                }
                if (count($this->column_search) - 1 == $i)
                    $this->dt->groupEnd();
            }
            $i++;
        }

        if ($this->request->getPost('order')) {
            $this->dt->orderBy($this->column_order[$this->request->getPost('order')['0']['column']], $this->request->getPost('order')['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->dt->orderBy(key($order), $order[key($order)]);
        }
    }
    function get_datatables()
    {
        $this->_get_datatables_query();
        if ($this->request->getPost('length') != -1)
            $this->dt->limit($this->request->getPost('length'), $this->request->getPost('start'));
        $query = $this->dt->get();
        return $query->getResult();
    }
    function count_filtered()
    {
        $this->_get_datatables_query();
        return $this->dt->countAllResults();
    }
    public function count_all()
    {
        $tbl_storage = $this->db->table($this->table);
        return $tbl_storage->countAllResults();
    }


    public function getwarga()
    {
        $query = $this->db->table($this->table);
        return $query->get();
    }


}