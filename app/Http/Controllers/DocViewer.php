<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class DocViewer extends Controller
{
    public function index()
    {
        return view('docsTable');
    }
    public function upload()
    {
        return view('upload');
    }
}
