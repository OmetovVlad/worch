@extends('layouts.main')

@section('content')
	<form method="POST" action="{{route('choice.create')}}" enctype="multipart/form-data">
		@csrf

		<header>
			<h3 class="left">New choice</h3>
			<div class="right balance">{{$balance}} Wö</div>
			<div class="right deposit"><a href="{{ route('deposit') }}">Пополнить</a></div>
		</header>

		<main class="choice_new">
			<input name="name" placeholder="Choice name" type="text" class="name">

			<div class="variants">
				<div class="variant variant__head">
					<span>Варианты</span>
				</div>
				<div id="variant_list">
					<div class="variant">
						<input type="text" class="choice_name" placeholder="Название" name="choice_name[]">

						<div class="media-source-switcher">
							<div class="active" data-media="Device">С устройства</div>
							<div data-media="YouTube">YouTube видео</div>
						</div>
						<div class="input-file">
							<input type="file" class="choice_media" placeholder="Медиа" name="choice_media[]"
								   accept="video/*, image/*">
							<div class="icon">
								<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
									 stroke-width="1.5"
									 stroke="currentColor" class="w-6 h-6">
									<path stroke-linecap="round" stroke-linejoin="round"
										  d="M7.5 7.5h-.75A2.25 2.25 0 0 0 4.5 9.75v7.5a2.25 2.25 0 0 0 2.25 2.25h7.5a2.25 2.25 0 0 0 2.25-2.25v-7.5a2.25 2.25 0 0 0-2.25-2.25h-.75m0-3-3-3m0 0-3 3m3-3v11.25m6-2.25h.75a2.25 2.25 0 0 1 2.25 2.25v7.5a2.25 2.25 0 0 1-2.25 2.25h-7.5a2.25 2.25 0 0 1-2.25-2.25v-.75"/>
								</svg>
							</div>
							<span>Загрузить фото/видео файл</span>
						</div>

						<input type="text" class="choice_media_url hide" placeholder="YouTube видео" name="choice_media_url[]">

						<div class="media_preview"></div>

						<textarea class="choice_description" placeholder="Описание" name="choice_description[]"></textarea>

						<button class="delete_variant" type="button">Удалить вариант</button>
					</div>
				</div>
				<div class="variant variant__add">
					<div class="icon">
						<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
							 stroke="currentColor" class="w-6 h-6">
							<path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
						</svg>
					</div>
					<span>Add new choice</span>
				</div>
			</div>

		</main>
		<footer>
			<button id="createButton" type="submit" disabled>Опубликовать</button>
		</footer>
	</form>

@endsection
