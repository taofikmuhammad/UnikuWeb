<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css'); ?>">
    <title>Home</title>
    <script>
        var csrf_prilude = '<?= csrf_hash() ?>'
    </script>
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
        <h1 class="h2">Warga</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group mr-2">
            <a href="<?= base_url('warga/new'); ?>" class="btn btn-sm btn-outline-secondary">Tambah</a>
          </div>
        </div>
      </div>

      <h4>LIST DATA WARGA</h4>
       <div class="container-fluid">
        <div class="row justify-content-md-left" style="bottom: 10px;">
            <div class="col-md-12 col-xs-12">
                <div class="col-md-12">
                        <?php if (session()->getFlashdata('pesan')) : ?>
                            <div class="alert alert-success alert-dismissible">
                                <?= session()->getFlashdata('pesan'); ?>
                            </div>
                        <?php endif ?>
                    </div>
                <div class="card">
                    <div class="card-body">
                        <div class="row" style="padding: 10px;">
                           
                           <div class="col-xs-12">
                             <div class="form-group" style="margin-left: 10px">
                              <label>RT</label>
                              <select onchange="reload()" name="rt" class="form-control" style="width: 100%">
                                <option value="">Pilih RT</option>
                                <?php foreach ($rt as $key): ?>
                                <option value="<?=$key->no_rt?>"><?=$key->no_rt?></option>
                                <?php endforeach ?>
                              </select>
                           </div>
                           </div>

                           <div class="col-xs-12">
                              <div class="form-group" style="margin-left: 10px">
                              <label>RW</label>
                              <select onchange="reload()" name="rw" class="form-control" style="width: 100%">
                                <option value="">Pilih RW</option>
                                <?php foreach ($rw as $key): ?>
                                <option value="<?=$key->no_rw?>"><?=$key->no_rw?></option>
                                <?php endforeach ?>
                              </select>
                           </div>
                           </div>

                           <div class="col-xs-12">
                              <div class="form-group" style="margin-left: 10px">
                                <label>Cari</label>
                                <input onkeyup="reload()" type="text" name="cari" class="form-control">
                              </div>
                           </div>
                         

                        </div>
                    </div>
                </div>
              </div>
            </div>
          </div>

          <div class="container-fluid" style="margin-top: 10px">
            <div class="row justify-content-md-left">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                        </div>
                        <div class="card-body">
                        <div class="table-responsive">
                          <table class="table table-bordered table-sm"  id="tabel_warga">
                            <thead>
                              <tr>
                                <th>No.</th>
                                <th>NIK</th>
                                <th>Nama Lengkap</th>
                                <th>Tempat Lahir</th>
                                <th>Tanggal Lahir</th>
                                <th>Alamat</th>
                                <th>Aksi</th>
                              </tr>
                            </thead>
                            <tbody></tbody>
                          </table>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

      

    </main>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.1/js/dataTables.bootstrap4.min.js"></script>
    <script type="text/javascript">
        
    var table;
    var rt    = $('[name="rt"]');
    var rw    = $('[name="rw"]');
    var cari  = $('[name="cari"]');

    $(() => {
        table = $('#tabel_warga').DataTable({
            "processing": true,
            "serverSide": true,
            "searching": false,
            "order": [],
            "ajax": {
                "url": "<?= base_url('/warga/listWarga') ?>",
                "type": "POST",
                "data": function(data) {
                    data.csrf_prilude = csrf_prilude,
                    data.rt   = rt.val(),
                    data.rw   = rw.val(),
                    data.cari = cari.val()
                }
            },
            "columDefs": [{
                "targets": [0],
                "orderable": false,
            }, ],
        });
        table.on('xhr.dt', function(e, settings, json, xhr) {
            csrf_prilude = json.<?= csrf_token() ?>;
        });
    })
    const reload = () => {
        table.ajax.reload()
    }

    </script>

    <script src="<?= base_url('assets/js/bootstrap.min.js'); ?>"></script>
</body>

</html>