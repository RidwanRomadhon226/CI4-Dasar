<?= $this->extend('layouts/templates') ?>


<?= $this->section('content') ?>

<!-- Begin page content -->
<main role="main" class="container">
  <h1 class="mt-5">Komik</h1>
  <p class="lead">Komik Page</p>
  <form action="/komik/update/<?= $komik['slug'] ?>" method="post">
    <?= csrf_field() ?>
    <input type="hidden" value="<?= $komik['id'] ?>" name="id" id="">
    <input type="hidden" value="<?= $komik['slug'] ?>" name="slug" id="">
    <div class="form-group">
      <label for="exampleFormControlInput1">Judul</label>
      <input type="text" name="judul" class="form-control <?= ($validation->hasError('judul')) ? 'is-invalid' : ''; ?>" id="exampleFormControlInput1" value="<?= (old('judul')) ? old('judul') : $komik['judul']; ?>">
      <div class="invalid-feedback">
        <?= $validation->getError('judul') ?>
      </div>
    </div>
    <div class="form-group">
      <label for="exampleFormControlInput1">Penerbit</label>
      <input type="text" name="penerbit" class="form-control  <?= ($validation->hasError('penerbit')) ? 'is-invalid' : ''; ?>" id="exampleFormControlInput1" value="<?= (old('penerbit')) ? old('penerbit') : $komik['penerbit']; ?>">
      <div class="invalid-feedback">
        <?= $validation->getError('penerbit') ?>
      </div>
    </div>
    <div class="form-group">
      <label for="exampleFormControlInput1">Penulis</label>
      <input type="text" name="penulis" class="form-control  <?= ($validation->hasError('penulis')) ? 'is-invalid' : ''; ?>" id="exampleFormControlInput1" value="<?= (old('penulis')) ? old('penulis') : $komik['penulis']; ?>">
      <div class="invalid-feedback">
        <?= $validation->getError('penulis') ?>
      </div>
    </div>

    <button type="submit" class="btn btn-primary">Save</button>
  </form>

</main>

<?= $this->endSection('content') ?>