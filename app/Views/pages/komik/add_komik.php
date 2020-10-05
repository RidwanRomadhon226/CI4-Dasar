<?= $this->extend('layouts/templates') ?>


<?= $this->section('content') ?>

<!-- Begin page content -->
<main role="main" class="container">
  <h1 class="mt-5">Komik</h1>
  <p class="lead">Komik Page</p>
  <form action="/komik/save" method="post">
    <?= csrf_field() ?>
    <div class="form-group">
      <label for="exampleFormControlInput1">Judul</label>
      <input type="text" name="judul" class="form-control <?= ($validation->hasError('judul')) ? 'is-invalid' : ''; ?>" value="<?= old('judul') ?>" id="exampleFormControlInput1" placeholder="">
      <div class="invalid-feedback">
        <?= $validation->getError('judul') ?>
      </div>
    </div>
    <div class="form-group">
      <label for="exampleFormControlInput1">Penerbit</label>
      <input type="text" name="penerbit" class="form-control  <?= ($validation->hasError('penerbit')) ? 'is-invalid' : ''; ?>" value="<?= old('penerbit') ?>" id="exampleFormControlInput1" placeholder="">
      <div class="invalid-feedback">
        <?= $validation->getError('penerbit') ?>
      </div>
    </div>
    <div class="form-group">
      <label for="exampleFormControlInput1">Penulis</label>
      <input type="text" name="penulis" class="form-control  <?= ($validation->hasError('penulis')) ? 'is-invalid' : ''; ?>" value="<?= old('penulis') ?>" id="exampleFormControlInput1" placeholder="">
      <div class="invalid-feedback">
        <?= $validation->getError('penulis') ?>
      </div>
    </div>

    <button type="submit" class="btn btn-primary">Save</button>
  </form>

</main>

<?= $this->endSection('content') ?>