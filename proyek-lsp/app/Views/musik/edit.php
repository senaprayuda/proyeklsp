<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>

<div class="container">
    <div class="row">
        <div class="col-8">
            <h2 class="my-3">Ubah Data musik <?= $musik['judul']; ?></h2>

            <form action="/musik/update/<?= $musik['id']; ?>" method="POST" enctype="multipart/form-data">

                <?= csrf_field(); ?>

                <input type="hidden" name="slug" value="<?= $musik['slug']; ?>">

                <input type="hidden" name="sampulLama" value="<?= $musik['sampul']; ?>">

                <div class="form-group row">
                    <label for="judul" class="col-sm-2 col-form-label">Judul</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control <?= ($validation->hasError('judul')) ? 'is-invalid' : ''; ?>" id="judul" name="judul" autofocus value="<?= (old('judul')) ? old('judul') : $musik['judul'] ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('judul'); ?>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="penyanyi" class="col-sm-2 col-form-label">penyanyi</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="penyanyi" name="penyanyi" value="<?= (old('penyanyi')) ? old('penyanyi') : $musik['penyanyi'] ?>" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="tahun" class="col-sm-2 col-form-label">tahun</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="tahun" name="tahun" value="<?= (old('tahun')) ? old('tahun') : $musik['tahun'] ?>" required>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="link" class="col-sm-2 col-form-label">embed Youtube</label>
                    <div class="col-sm-10">
                    <textarea name="link" id="link" rows="10" class="d-block w-100 form-control"><?= $musik['link'] ?></textarea>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="sampul" class="col-sm-2 col-form-label">Sampul</label>
                    <div class="col-sm-2">
                        <img src="/img/<?= $musik['sampul']; ?>" class="img-thumbnail img-preview">
                    </div>
                    <div class="col-sm-8">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input <?= ($validation->hasError('sampul')) ? 'is-invalid' : ''; ?>" id="sampul" onchange="previewImg()" name="sampul">
                            <div class="invalid-feedback">
                                <?= $validation->getError('sampul'); ?>
                            </div>
                            <label class="custom-file-label" for="sampul"><?= $musik['sampul']; ?></label>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary">Ubah Data</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>