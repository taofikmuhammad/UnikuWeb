<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css'); ?>">
    <title>Tambah Warga</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-danger">
        <a class="navbar-brand" href="#">Uniku</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="<?= base_url('auth'); ?>">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="<?= base_url('warga'); ?>">Warga</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Provinsi</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Pengaturan</a>
                </li>
            </ul>
            <div class="ml-auto navbar-nav">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="#"><?= session()->get('nama'); ?> <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="javascript::void(0)">| <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="<?= base_url('auth/logout'); ?>">Logout <span class="sr-only">(current)</span></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main role="main" class="col-md-9 ml-sm-auto col-lg-12 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Tambah Warga</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group mr-2">
            <a href="javascript:void(0)" onclick="history.back()" class="btn btn-sm btn-outline-secondary">Kembali</a>
          </div>
        </div>
      </div>

      <div class="container-fluid">
        <div class="row justify-content-md-left">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <form action="<?= base_url('warga/create'); ?>" method="post">
                            <?= csrf_field() ?>
                            <h2 class="text-center"></h2>
                            <?php if (session()->getFlashdata('eror')) : ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong><?= session()->getFlashdata('eror') ?></strong>
                                </div>
                            <?php endif; ?>
                            <div class="form-group">
                                <label for="">NIK</label>
                                <input type="number" name="nik" class="form-control" placeholder="NIK" required="required">
                                <?php if ($validation->hasError('nik')) : ?>
                                    <small class="text-danger"><?= $validation->getError('nik'); ?></small>
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <label for="">Nama Lengkap</label>
                                <input type="text" name="nama_lengkap" class="form-control" placeholder="Nama Lengkap" required="required">
                                <?php if ($validation->hasError('nama_lengkap')) : ?>
                                    <small class="text-danger"><?= $validation->getError('nama_lengkap'); ?></small>
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <label for="">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Password" required="required">
                                <?php if ($validation->hasError('password')) : ?>
                                    <small class="text-danger"><?= $validation->getError('password'); ?></small>
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <label for="">Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" class="form-control" placeholder="Tempat Lahir" required="required">
                                <?php if ($validation->hasError('tempat_lahir')) : ?>
                                    <small class="text-danger"><?= $validation->getError('tempat_lahir'); ?></small>
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <label for="">Tanggal Lahir</label>
                                <input type="date" name="tanggal_lahir" class="form-control" placeholder="Tanggal Lahir" required="required">
                                <?php if ($validation->hasError('tanggal_lahir')) : ?>
                                    <small class="text-danger"><?= $validation->getError('tanggal_lahir'); ?></small>
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <label for="">Alamat</label>
                                <textarea name="alamat" class="form-control"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="">Warga Negara</label>
                                <input type="text" maxlenght="3" name="warganegara" class="form-control" placeholder="Warga Negara" required="required">
                            </div>
                            <div class="form-group">
                                <label for="">Golongan Darah</label>
                                <input type="text" maxlenght="3" name="golongan_darah" class="form-control" placeholder="Golongan Darah" required="required">
                            </div>
                            <div class="form-group">
                                <label for="">Agama</label>
                                <input type="text" maxlenght="15" name="agama" class="form-control" placeholder="Agama" required="required">
                            </div>
                            <div class="form-group">
                                <label for="">Pilih RT</label>
                                <select name="no_rt" class="form-control" required>
                                    <option value="">Pilih RT</option>
                                    <?php foreach ($rt as $x) : ?>
                                        <option value="<?= $x->no_rt ?>"><?= $x->no_rt.'-'.$x->nama_ketua ?></option>
                                    <?php endforeach ?>
                                </select>
                                <?php if ($validation->hasError('no_rt')) : ?>
                                    <small class="text-danger"><?= $validation->getError('no_rt'); ?></small>
                                <?php endif; ?>
                                
                            </div>
                            <div class="form-group">
                                <label for="">Kecamatan</label>
                                <select name="id_kecamatan" class="form-control" required>
                                    <option value="">Pilih Kecamatan</option>
                                    <?php foreach ($kecamatan as $x) : ?>
                                        <option value="<?= $x->id_kecamatan ?>"><?= $x->nama_kecamatan ?></option>
                                    <?php endforeach ?>
                                </select>
                                <?php if ($validation->hasError('id_kecamatan')) : ?>
                                    <small class="text-danger"><?= $validation->getError('id_kecamatan'); ?></small>
                                <?php endif; ?>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

     
    </main>

    <script src="<?= base_url('assets/js/bootstrap.min.js'); ?>"></script>
</body>

</html>