<?php

namespace App\Http\Controllers;

use App\Models\TgChat;
use App\Models\User;
use App\Models\Wallet;
use DefStudio\Telegraph\Keyboard\Button;
use DefStudio\Telegraph\Keyboard\Keyboard;
use DefStudio\Telegraph\Models\TelegraphChat;
use DefStudio\Telegraph\Telegraph;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request) {

//		dd($request);

		$chat_data = TgChat::where([['chat_id', '=', $request->user]])->first();
		$chat = TelegraphChat::find($chat_data->id);
		$user_data = $chat->memberInfo($request->user)->user();

		$user = User::where([['telegram', '=', $request->user]])->first();
		if ($user) {
			if ($user->role != 'expert') {
				$user = User::updateOrCreate(
					[
						'telegram'   => $user_data->id(),
					],
					[
						'firstname' => $user_data->firstName(),
						'surname' => $user_data->lastName(),
						'nickname' => $user_data->username(),
						'language' => $user_data->languageCode(),
						'is_premium' => $user_data->isPremium(),
					],
				);
			} else {
				$user = User::updateOrCreate(
					[
						'telegram'   => $user_data->id(),
					],
					[
						'language' => $user_data->languageCode(),
						'is_premium' => $user_data->isPremium(),
					],
				);
			}
		} else {
			$user = User::updateOrCreate(
				[
					'telegram'   => $user_data->id(),
				],
				[
					'firstname' => $user_data->firstName(),
					'surname' => $user_data->lastName(),
					'nickname' => $user_data->username(),
					'language' => $user_data->languageCode(),
					'is_premium' => $user_data->isPremium(),
				],
			);
		}

		Auth::login($user);

		if (!Wallet::where('user_id', Auth::user()->id)->first()) {
			Wallet::create([
				'user_id' => Auth::user()->id,
				'balance' => 500,
			]);
		}

		if ($request->choice) {
			return redirect()->route('choice.show', ['choice' => $request->choice]);
		}

		if ($request->new_expert) {
			return redirect()->route('expert.form');
		}

		return redirect()->route('choice.form');
	}
}
