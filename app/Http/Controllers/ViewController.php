<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AboutModel;

class ViewController extends Controller
{
    public function adminProfile()
    {
        $get = AboutModel::get();
        $data = $get[0];

        return view('adminPanel.adminProfile', compact('data'));
        // dd($data[0]['id']);
    }
}
