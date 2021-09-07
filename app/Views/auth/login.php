<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= base_url('assets/css/bootstrap.min.css'); ?>">
    <title>Home</title>
</head>

<body>
    <div class="container-fluid" style="margin-top: 100px;">
        <div class="row justify-content-md-center align-items-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <form action="<?= base_url('auth'); ?>" method="post">
                            <?= csrf_field() ?>
                            <h2 class="text-center">Log in</h2>
                            <?php if (session()->getFlashdata('eror')) : ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong><?= session()->getFlashdata('eror') ?></strong>
                                </div>
                            <?php endif; ?>
                            <div class="form-group">
                                <label for="">NIK</label>
                                <input type="number" name="nik" class="form-control" placeholder="NIK" required="required">
                            </div>
                            <div class="form-group">
                                <label for="">Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Password" required="required">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block">Log in</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>