<?php

namespace App\Controllers;

class Contact extends BaseController
{
  public function index()
  {
    $data = [
      'title' => 'Ridwan Contact'
    ];

    return view('pages/contact', $data);
  }

  //--------------------------------------------------------------------

}
