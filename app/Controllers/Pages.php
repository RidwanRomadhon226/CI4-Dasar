<?php

namespace App\Controllers;

class Pages extends BaseController
{
  public function index()
  {
    $data = [
      'title' => 'Ridwan About'
    ];

    return view('pages/home', $data);
  }

  //--------------------------------------------------------------------

}
