<?php

namespace App\Controllers;

use App\Models\KomikModel;

class Komik extends BaseController
{
  protected $komikModel;
  public function __construct()
  {
    $this->komikModel = new KomikModel();
  }

  public function index()
  {
    // $komik = $this->komikModel->findAll();
    $data = [
      'title' => "Komik",
      'komik' => $this->komikModel->getKomik()
    ];



    return view('pages/komik/index', $data);
  }


  public function detailKomik($slug)
  {



    $komik = $this->komikModel->getKomik($slug);
    $data = [
      'title' => 'detail Komik',
      'komik' => $komik
    ];

    if (empty($this->komikModel->getKomik($slug))) {
      return redirect('/komik');
    }
    // dd($data);
    return view('pages/komik/detail_komik', $data);
  }



  public function addKomik()
  {
    // session();
    $data = [
      'title' => 'form Tambah data',
      'validation' => \Config\Services::validation()
    ];
    // dd($data);
    return view('pages/komik/add_komik', $data);
  }


  public function saveKomik()
  {

    // if (!$this->validate([
    //   'judul' => 'required|is_unique[komik.judul]',
    //   'penerbit' => 'required|is_unique[komik.judul]',
    //   'penulis' => 'required|is_unique[komik.judul]',
    // ])) {
    //   $validation = \Config\Services::validation();
    //   return redirect()->to('/komik/create')->withInput()->with('validation', $validation);
    // }

    if (!$this->validate([
      'judul' => [
        'rules' => 'required|is_unique[komik.judul]',
        'errors' => [
          'required' => '{field} Judul Harus Di isi',
          'is_unique' => '{field} Penerbit sudah tersedia',
        ]
      ],
      'penerbit' => [
        'rules' => 'required',
        'errors' => [
          'required' => '{field} Penerbit Harus di isi',
        ]
      ],
      'penulis' => [
        'rules' => 'required',
        'errors' => [
          'required' => '{field} penulis Harus di isi',
        ]
      ],
      'sampul' => [
        'rules' =>  'max_size[sampul,1024]|is_image[sampul]|mime_in[sampul,image/jpg,image/jpeg,image/png]',
        'errors' => [
          // 'uploaded' => '{field} Photo Harus di isi',
          'max_size' => '{field} Ukuran Harus 1 mb',
          'is_image' => '{field} yang anda pilih bukan gambar',
          'mime_in' => '{field} yang anda pilih bukan gambar',
        ]
      ],
    ])) {
      // $validation = \Config\Services::validation();
      // return redirect()->to('/komik/create')->withInput()->with('validation', $validation);
      return redirect()->to('/komik/create')->withInput();
    }
    // session();

    // dd($this->request->getVar());



    $fileSampul = $this->request->getFile('sampul');

    // Apakah Di update data 
    if ($fileSampul->getError() == 4) {
      # code...
      $fileSampul = 'default.png';
    } else {
      // Generete nama sampul rndom
      $namaSampul = $fileSampul->getRandomName();
      // pindahkan File ke folder
      $fileSampul->move('img', $namaSampul);
      // Ambil Nama Sampul
      $fileSampul = $fileSampul->getName();
    }

    // dd($fileSampul);

    $slug = url_title($this->request->getVar('judul'), '-', true);
    $this->komikModel->save([
      'judul' => $this->request->getVar('judul'),
      'penerbit' => $this->request->getVar('penerbit'),
      'penulis' => $this->request->getVar('penulis'),
      'slug' => $slug,
      'sampul' => $fileSampul,
    ]);

    session()->setFlashdata('pesan', 'Berhasil di Input');
    // echo  `<script> $('.alert').alert(); </script>`;
    return redirect()->to('/komik');
  }

  public function delete($id)
  {
    // cari gambar dengan id 

    $komik = $this->komikModel->find($id);

    // Hapus gambar 

    // cek gambar default

    if ($komik['sampul'] != 'default.png') {
      unlink('img/' . $komik['sampul']);
    }


    $this->komikModel->delete($id);
    session()->setFlashdata('pesan', 'Berhasil di Hapus');
    return redirect()->to('/komik');
  }

  public function editKomik($slug)
  {
    $komik = $this->komikModel->getKomik($slug);
    $data = [
      'title' => 'detail Komik',
      'validation' =>  \Config\Services::validation(),
      'komik' => $komik
    ];

    return view('pages/komik/edit_komik', $data);
  }

  public function updateKomik($slug)
  {
    // dd($this->request->getVar());
    $komikLama = $this->komikModel->getKomik($this->request->getVar('slug'));
    if ($komikLama['judul'] == $this->request->getVar('judul')) {
      $rule_judul = 'required';
    } else {
      $rule_judul = 'required|is_unique[komik.judul]';
    }

    if (!$this->validate([
      'judul' => [
        'rules' => $rule_judul,
        'errors' => [
          'required' => '{field} Judul Harus Di isi',
          'is_unique' => '{field} Judul sudah tersedia',
        ]
      ],
      'penerbit' => [
        'rules' => 'required',
        'errors' => [
          'required' => '{field} Penerbit Harus di isi',
        ]
      ],
      'penulis' => [
        'rules' => 'required',
        'errors' => [
          'required' => '{field} penulis Harus di isi',
        ]
      ],
      'sampul' => [
        'rules' =>  'max_size[sampul,1024]|is_image[sampul]|mime_in[sampul,image/jpg,image/jpeg,image/png]',
        'errors' => [
          // 'uploaded' => '{field} Photo Harus di isi',
          'max_size' => '{field} Ukuran Harus 1 mb',
          'is_image' => '{field} yang anda pilih bukan gambar',
          'mime_in' => '{field} yang anda pilih bukan gambar',
        ]
      ],
    ])) {
      // $validation = \Config\Services::validation();
      return redirect()->to('/komik/edit/' . $this->request->getVar('slug'))->withInput();
    }

    $fileSampul = $this->request->getFile('sampul');


    //Cek Gambar ,  apakah tetap gambar lama
    if ($fileSampul->getError() == 4) {
      $namaSampul = $this->request->getVar('sampul_lama');
      # code...
    } else {
      // Generete nama sampul rndom
      $namaSampul = $fileSampul->getRandomName();
      // pindahkan File ke folder
      $fileSampul->move('img', $namaSampul);
      // Ambil Nama Sampul
      $fileSampul = $fileSampul->getName();
      // Halus File Lama 
      if ($komikLama['sampul'] != 'default.png') {
        unlink('img/' . $this->request->getVar('sampul_lama'));
      }
      // unlink('/img/' . $this->request->getVar('sampul_lama'));
    }



    $judul = $this->request->getVar('judul');

    $slug = url_title($judul, '-', true);
    $this->komikModel->save([
      'id' => $this->request->getVar('id'),
      'judul' => $judul,
      'penerbit' => $this->request->getVar('penerbit'),
      'penulis' => $this->request->getVar('penulis'),
      'slug' => $slug,
      'sampul' => $namaSampul,
    ]);

    session()->setFlashdata('pesan', 'Berhasil di Di ubah');
    // echo  `<script> $('.alert').alert(); </script>`;
    return redirect()->to('/komik');
  }


  //--------------------------------------------------------------------

}
