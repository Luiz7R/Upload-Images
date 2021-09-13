<?php

namespace App\Http\Controllers;

use App\Models\Images;
use Illuminate\Http\Request;

class ImagesController extends Controller
{
    public function getImages()
    {
        $images = Images::all();

        return view('homepage', compact('images') );
    }
}
