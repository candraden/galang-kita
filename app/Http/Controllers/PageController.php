<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;

class PageController extends Controller
{
    public function soon(string $page)
    {
        return view('soon', ['title' => Str::headline($page)]);
    }
}
