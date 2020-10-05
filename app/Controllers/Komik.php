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
    ])) {
      $validation = \Config\Services::validation();
      return redirect()->to('/komik/create')->withInput()->with('validation', $validation);
    }
    // session();

    // dd($this->request->getVar());
    $slug = url_title($this->request->getVar('judul'), '-', true);
    $this->komikModel->save([
      'judul' => $this->request->getVar('judul'),
      'penerbit' => $this->request->getVar('penerbit'),
      'penulis' => $this->request->getVar('penulis'),
      'slug' => $slug,
    ]);

    session()->setFlashdata('pesan', 'Berhasil di Input');
    // echo  `<script> $('.alert').alert(); </script>`;
    return redirect()->to('/komik');
  }

  public function delete($id)
  {
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
    ])) {
      $validation = \Config\Services::validation();
      return redirect()->to('/komik/edit/' . $this->request->getVar('slug'))->withInput()->with('validation', $validation);
    }


    $judul = $this->request->getVar('judul');

    $slug = url_title($judul, '-', true);
    $this->komikModel->save([
      'id' => $this->request->getVar('id'),
      'judul' => $judul,
      'penerbit' => $this->request->getVar('penerbit'),
      'penulis' => $this->request->getVar('penulis'),
      'slug' => $slug,
    ]);

    session()->setFlashdata('pesan', 'Berhasil di Di ubah');
    // echo  `<script> $('.alert').alert(); </script>`;
    return redirect()->to('/komik');
  }


  //--------------------------------------------------------------------

}
