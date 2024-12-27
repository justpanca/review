<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function homeaja() {
        return view ("/home");
    }

    public function tableaja() {
        return view ("/data-table");
    }
}
