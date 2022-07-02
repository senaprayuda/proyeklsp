<?= $this->extend('layout/template'); ?>

<?= $this->section('content'); ?>
<div class="container">
    <div class="row">
        <div class="col">
            <h2 class="mt-2">Detail musik <?= $musik['judul']; ?></h2>
            <div class="card mb-3">
                <div class="row no-gutters">
                    <div class="col-4 col-md-4 p-1 mb-2">
                        <img class="mb-2" src="/img/<?= $musik['sampul']; ?>" width="100%">


                        <a href="/musik" class="btn btn-primary align-items-end">
                            <i class="fa fa-arrow-left"></i>
                            Kembali
                        </a>

                        <a href="/musik/edit/<?= $musik['slug']; ?>" class="btn btn-warning">
                            <i class="fa fa-pencil-alt"></i>
                            Ubah</a>

                        <form action="/musik/<?= $musik['id']; ?>" method="POST" class="d-inline">

                            <?= csrf_field(); ?>

                            <input type="hidden" name="_method" value="DELETE">

                            <button type="submit" class="btn btn-danger" onclick="return confirm('data akan dihapus, apakah anda yakin ?');">
                                <i class="fa fa-trash"></i>
                                Hapus</button>
                        </form>
                    </div>
                    <div class="col-8 col-md-8">
                        <div class="card-body">
                            <h4 class="card-title"> <b>Judul musik : </b> <?= $musik['judul']; ?></h3>
                                <p class="card-text"><b>penyanyi :</b> <?= $musik['penyanyi']; ?></p>
                                <p class="card-text"><b>tahun :</b> <?= $musik['tahun']; ?></small></p>


                                <!-- <iframe width="420" height="315" src="" frameborder="0" class="embed-responsive-item" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe> -->
                                <?= $musik['link']; ?> 




                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>