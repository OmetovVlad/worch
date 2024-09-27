<?php

namespace App\Http\Controllers;

use App\Models\Choice;
use App\Models\Order;
use App\Models\User;
use App\Models\Variant;
use App\Models\Vote;
use App\Models\Wallet;
use DefStudio\Telegraph\Keyboard\Button;
use DefStudio\Telegraph\Keyboard\Keyboard;
use DefStudio\Telegraph\Models\TelegraphChat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;

class ChoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
		$user_id = Auth::user()->id;
		$balance = Wallet::where('user_id', $user_id)->first()->balance;

		return view('choice.index', compact('balance'));
    }

	/**
	 * Show the form for creating a new resource.
	 * @param Request $request
	 */
    public function create(Request $request)
    {
		function GetYoutubeVideoID($url)
		{
			if(strripos($url, "youtube.com"))
			{
				parse_str(parse_url($url, PHP_URL_QUERY), $you);

				if ($you) {
					if (isset($you['v'])) {
						$youtube_id = $you["v"];
					} else {
						$you_mass = explode("/", $url);
						$youtube_id = $you_mass[count($you_mass) - 1];
					}

				} else {
					$youtube_id = explode("/", $url)[4];
				}
			}
			elseif(strripos($url, "youtu.be"))
			{
				$you_mass = explode("/", $url);
				$youtube_id = $you_mass[count($you_mass) - 1];
			}

			if(!empty($youtube_id)) return $youtube_id;
			return false;
		}

		$user = Auth::user();

		$this->validate($request, [
			'name'=> 'required|string',
			'choice_name'=> ['array'],
			'choice_name.*' => 'nullable',
			'choice_media'=> ['array'],
			'choice_media.*' => 'nullable',
			'choice_media_url'=> ['array'],
			'choice_media_url.*' => 'nullable',
			'choice_description'=> ['array'],
			'choice_description.*' => 'nullable'
		]);

		$new_choice = Choice::create([
			'user' => $user->id,
			'name' => $request->name,
		]);

		$upload_path = '/upload/images/';

		$i = 0;

		foreach ($request->choice_name as $choice_name) {
			$img_path = null;
			if (isset($request->choice_media[$i])) {

				$photo = $request->choice_media[$i];
				$filename = Str::uuid() . '.' . $photo->extension();
				$photo->move(public_path() . $upload_path , $filename);

				$img_path = $upload_path . $filename;
			}

			Variant::create([
				'choice' => $new_choice->id,
				'name' => $choice_name,
				'img_path' => $img_path,
				'url' => $request->choice_media_url[$i] ? GetYoutubeVideoID($request->choice_media_url[$i]) : null,
				'description' => $request->choice_description[$i],
			]);

			$i++;
		}

		$chat = TelegraphChat::find($user->id);
		$chat->photo('https://lipsum.app/500x340/53158a/fff')
			->message('Опрос <b>«'.$new_choice->name.'»</b>
<a href="https://t.me/worch_app_bot?start='.$new_choice->id.'">Принять участие в опросе</a>')
			->keyboard(Keyboard::make()->buttons([
				Button::make('Открыть опрос')->webApp(env('APP_URL').'/login?user='.$user->telegram.'&choice='.$new_choice->id),
			]))
			->send();

		return redirect()->route('choice.edit', ['choice' => $new_choice->id]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Choice $choice)
    {
		$variants = Variant::where([['choice', '=' , $choice->id]])->get();
		$my_vote = Vote::where([['choice', '=' , $choice->id], ['user', '=' , Auth::user()->id]])->first();
		$votes = Vote::where([['choice', '=' , $choice->id]])->get();
		$order = Order::where([['choice', '=' , $choice->id]])->first();

		if ($my_vote) {	$my_vote = true; } else { $my_vote = false; }

		$votes_array = [];
		$users = [];

		foreach ($variants as $variant) {
			foreach ($votes as $vote) {
				if ($vote->variant == $variant->id) {
					$votes_array[$variant->id][] = $vote;
					$users[] = $vote->user;
				}
			}
		}

		$users = User::whereIn('id' , $users)->get();

//		dd($order);

		return view('choice.show', compact('choice', 'variants', 'my_vote', 'votes_array', 'users', 'order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Choice $choice)
    {
		$balance = Wallet::where('user_id', Auth::user()->id)->first()->balance;
		$experts = User::where([['role', '=' , 'expert']])->get();

		return view('choice.edit', compact('choice', 'balance', 'experts'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Choice $choice)
    {
		if ($request->has('type')) {

			if($request->vote) {

				$vote = Vote::create([
					'choice' => $choice->id,
					'variant' => $request->vote,
					'user' => Auth::user()->id,
				]);

				$order = Order::where([['choice', '=' , $choice->id]])->first();

				if ($order) {
					if (Auth::user()->id == $order->expert) {

						if (isset($request->expert_answer)) {
							$expert = User::where([['id', '=', $order->expert]])->first();
							$expert_balance = $expert->balance;

							$upload_path = '/upload/answers/';
							$video = $request->expert_answer;
							$filename = Str::uuid() . '.' . $video->extension();
							$video->move(public_path() . $upload_path , $filename);

							$video_path = $upload_path . $filename;

							$order->update([
								'video_path' => $video_path,
								'is_done' => true,
							]);

							$expert->update([
								'balance' => $expert_balance + $order->price,
							]);

							$chat = TelegraphChat::find($choice->user);

							$chat->video('../public' . $video_path)
								->message('Эксперт дал ответ на ваш вопрос')
								->send();

						} else {
							$vote->delete();
						}

					}
				}

			}

		} else {

			$user_wallet = Wallet::where('user_id', Auth::user()->id)->first();
			$expert = User::where([['id', '=', $request->expert], ['role', '=', 'expert']])->first();

			if ($expert) {
				if ($expert->price <= $user_wallet->balance) {
					$user_wallet->update([
						'balance' => $user_wallet->balance - $expert->price,
					]);

					Order::create([
						'choice' => $choice->id,
						'expert' => $expert->id,
						'price' =>  $expert->price,
						'video_path' => '',
					]);

					$chat = TelegraphChat::find($expert->id);

					$chat->photo('https://lipsum.app/500x500/fcfcfc/ccc')
						->message('Запрос экспертного мнения в опросе

Откройте приложение и проголуйте за 1 из вариантов и прикрепите видео ответ')
						->keyboard(Keyboard::make()->buttons([
							Button::make('Открыть опрос')->webApp(env('APP_URL').'/login?user='.$expert->telegram.'&choice='.$choice->id),
						]))
						->send();
				}
			}

		}

		return redirect()->route('choice.show', ['choice' => $choice->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Choice $choice)
    {
        //
    }
}
