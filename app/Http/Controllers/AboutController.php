<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AboutModel;

class AboutController extends Controller
{
    public function index() {
        $details = AboutModel::all();

        return response()->json($details);
    }
}
