<?= $this->extend('layouts/templates') ?>


<?= $this->section('content') ?>

<!-- Begin page content -->
<main role="main" class="container">
  <h1 class="mt-5">Komik</h1>
  <p class="lead">Komik Page</p>

  <div class="card mb-3" style="max-width: 540px;">
    <div class="row no-gutters">
      <div class="col-md-4">
        <img src="<?= $komik['sampul'] ?>" class="card-img" alt="...">
      </div>
      <div class="col-md-8">
        <div class="card-body">
          <h5 class="card-title"><?= $komik['judul'] ?></h5>
          <p class="card-text">Penerbit : <?= $komik['penerbit'] ?> || Penulis : <?= $komik['penulis'] ?></p>
          <p class="card-text"><small class="text-muted"><?= $komik['created_at'] ?></small></p>
          <a href="" class="btn btn-success">edit</a>
          <form action="/komik/del/<?= $komik['id'] ?>" method="post">
            <input type="hidden" name="_method" value="DELETE">
            <button type="submit" class="btn btn-danger" onclick="return confirm('anda yakin Menghapus');">Del</button>
          </form>
        </div>
      </div>
    </div>
  </div>

</main>

<?= $this->endSection('content') ?>