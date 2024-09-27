<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ExpertController extends Controller
{
    public function index()
    {
		return view('expert.index');
    }

    public function create(Request $request)
    {
//        dd($request);

		$upload_path = '/upload/experts/';
		$img_path = Auth::user()->img_path;

		if (isset($request->expert_image)) {
			$photo = $request->expert_image;
			$filename = Str::uuid() . '.' . $photo->extension();
			$photo->move(public_path() . $upload_path , $filename);

			$img_path = $upload_path . $filename;
		}

		$user = User::where('id', Auth::user()->id);

		$user->update([
			'img_path' => $img_path,
			'firstname' => $request->firstname,
			'surname' => $request->surname,
			'nickname' => $request->nickname,
			'role' => 'expert',
			'price' => $request->price,
		]);

		dd($user);
    }
}
