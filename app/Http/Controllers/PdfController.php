<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;


class PdfController extends Controller
{
          public function github(){
            $pdf = PDF::loadView('pdf.template');
            return $pdf->stream('template.pdf');
          }
}
