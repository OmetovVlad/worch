<?php

namespace App\Telergam;

use App\Models\Choice;
use App\Models\TgChat;
use DefStudio\Telegraph\DTO\User;
use DefStudio\Telegraph\Handlers\WebhookHandler;
use DefStudio\Telegraph\Keyboard\Button;
use DefStudio\Telegraph\Keyboard\Keyboard;
use DefStudio\Telegraph\Models\TelegraphChat;
use DefStudio\Telegraph\Telegraph;
use Illuminate\Http\Request;

class Handler extends WebhookHandler
{
	public function start(string $choice): void
	{


		$chat_data = TgChat::where([['chat_id', '=', $this->chat->chat_id]])->first();
		$chat = TelegraphChat::find($chat_data->id);



//		$chat->photo('../public/assets/img/bot_main.jpg')
		if (strtolower($choice) != '') {

			function isValidUuid( $uuid ) {
				if (!is_string($uuid) || (preg_match('/^[a-f\d]{8}(-[a-f\d]{4}){4}[a-f\d]{8}$/i', $uuid) !== 1)) {
					return false;
				}
				return true;
			}

			if (isValidUuid($choice)) {
				$currentChoice = Choice::where('id', $choice)->first();

				if ($currentChoice) {
					$chat->photo('https://lipsum.app/500x500/fcfcfc/ccc')
						->message('Тут мог бы быть текст со смысловой нагрузкой про <u><b>Worch</b></u>, но пока что он просто такой

Откройте приложение и проголуйте за 1 из вариантов')
						->keyboard(Keyboard::make()->buttons([
							Button::make('Открыть опрос')->webApp(env('APP_URL').'/login?user='.$this->chat->chat_id.'&choice='.$choice),
							Button::make('Открыть приложение')->webApp(env('APP_URL').'/login?user='.$this->chat->chat_id),
							Button::make('Стать экспертом')->webApp(env('APP_URL').'/login?user='.$this->chat->chat_id.'&new_expert=1'),
						]))
						->send();
				} else {
					$chat->photo('https://lipsum.app/500x500/fcfcfc/ccc')
						->message('Тут мог бы быть текст со смысловой нагрузкой про <u><b>Worch</b></u>, но пока что он просто такой

Опрос, в котором вы пытаетесь принять участие, не существует!')
						->keyboard(Keyboard::make()->buttons([
							Button::make('Открыть приложение')->webApp(env('APP_URL').'/login?user='.$this->chat->chat_id),
							Button::make('Стать экспертом')->webApp(env('APP_URL').'/login?user='.$this->chat->chat_id.'&new_expert=1'),
						]))
						->send();
				}
			} else {
				$chat->photo('https://lipsum.app/500x500/fcfcfc/ccc')
					->message('Тут мог бы быть текст со смысловой нагрузкой про <u><b>Worch</b></u>, но пока что он просто такой

Опрос, в котором вы пытаетесь принять участие, не существует!')
					->keyboard(Keyboard::make()->buttons([
						Button::make('Открыть приложение')->webApp(env('APP_URL').'/login?user='.$this->chat->chat_id),
						Button::make('Стать экспертом')->webApp(env('APP_URL').'/login?user='.$this->chat->chat_id.'&new_expert=1'),
					]))
					->send();
			}
		} else {
			$chat->photo('https://lipsum.app/500x500/000/fff')
				->message('Тут мог бы быть текст со смысловой нагрузкой про <u><b>Worch</b></u>, но пока что он просто такой')
				->keyboard(Keyboard::make()->buttons([
					Button::make('Открыть приложение')->webApp(env('APP_URL').'/login?user='.$this->chat->chat_id),
					Button::make('Стать экспертом')->webApp(env('APP_URL').'/login?user='.$this->chat->chat_id.'&new_expert=1'),
				]))
				->send();
		}
	}

}
