<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ErrorController extends Controller
{
  public function notfound()
  {
      return view('errors.n404');
  }
  public function fatal()
  {
      return view('errors.n500');
  }
}
