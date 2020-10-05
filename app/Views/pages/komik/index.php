<?= $this->extend('layouts/templates') ?>


<?= $this->section('content') ?>

<!-- Begin page content -->
<main role="main" class="container">
  <h1 class="mt-5">Komik</h1>
  <p class="lead">Komik Page</p>
  <a href="/komik/create" class="btn btn-success">Add</a>

  <?php if (session()->getFlashdata('pesan')) : ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
      <strong>Berhasil!</strong> <?php echo session()->getFlashdata('pesan'); ?>
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
  <?php endif; ?>


  <table class="table">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Sampul</th>
        <th scope="col">Judul</th>
        <th scope="col">Aksi</th>
      </tr>
    </thead>
    <tbody>
      <?php $i = 1; ?>
      <?php foreach ($komik as $n) : ?>
        <tr>
          <th scope="row"> <?= $i++ ?> </th>
          <td>
            <img src="/img/<?= $n['sampul'] ?>" alt="" class="sampul">
          </td>
          <td><?= $n['judul'] ?></td>
          <td>
            <a href="/komik/edit/<?= $n['slug'] ?>" class="btn btn-success">edit</a>
            <a href="<?= base_url("komik") ?>/<?= $n['slug'] ?>" class="btn btn-success">detail</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

</main>

<?= $this->endSection('content') ?>