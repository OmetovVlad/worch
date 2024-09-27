<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Image;

class CompressImageController extends Controller
{
    public function compress(Request $request)
	{
		$this->validate($request, [
			'image'=> ['image']
		]);

		$imageName = "images/" . Str::uuid() . '.jpeg';
		Image::make($imageName, 60);

		return back()->withSuccess('Image Compressed');
	}
}
