@extends('layouts.main')

@section('content')
	<form method="POST" action="{{route('expert.create')}}" enctype="multipart/form-data">
		@csrf

		<header>
			<h3 class="center">Новый эксперт</h3>
		</header>

		<main class="expert_new">
			<div class="media_preview">
				@if(Auth::user()->img_path)
					<img src="{{Auth::user()->img_path}}">
				@endif
			</div>

			<div class="input-file">
				<input type="file" class="expert_image" placeholder="Медиа" name="expert_image" accept="video/*, image/*">
				<div class="icon">
					<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
						<path stroke-linecap="round" stroke-linejoin="round" d="M7.5 7.5h-.75A2.25 2.25 0 0 0 4.5 9.75v7.5a2.25 2.25 0 0 0 2.25 2.25h7.5a2.25 2.25 0 0 0 2.25-2.25v-7.5a2.25 2.25 0 0 0-2.25-2.25h-.75m0-3-3-3m0 0-3 3m3-3v11.25m6-2.25h.75a2.25 2.25 0 0 1 2.25 2.25v7.5a2.25 2.25 0 0 1-2.25 2.25h-7.5a2.25 2.25 0 0 1-2.25-2.25v-.75"/>
					</svg>
				</div>
				<span>Фото профиля</span>
			</div>

			<input name="firstname" placeholder="Имя" type="text" class="name" value="{{Auth::user()->firstname}}">

			<input name="surname" placeholder="Фамилия" type="text" class="name" value="{{Auth::user()->surname}}">

			<input name="nickname" placeholder="Псевдоним" type="text" class="name" value="{{Auth::user()->nickname}}">

			<input name="price" placeholder="Стоимость вашей экспертной оценки" type="text" class="name" value="{{Auth::user()->price}}">

		</main>
		<footer>
			<button id="createButton" type="submit">Стать экспертом</button>
		</footer>
	</form>

@endsection
