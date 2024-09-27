@extends('layouts.main')

@section('content')
	<form method="POST" action="{{route('choice.update', $choice->id)}}">
		@csrf
		<header>
			<h3 class="center">Голосование</h3>
		</header>

		<main class="choice_edit">

			<div class="votes">
				<div class="vote vote__head">
					<span>{{$choice->name}}</span>
				</div>

				@foreach($variants as $variant)
					<div class="vote">
						<label>
							<input type="radio" name="vote" value="{{$variant->id}}">

							<div class="vote_item">
								<div class="radio"></div>
								@if ($variant->img_path != null)
									<div class="vote_media">
									@if( str_contains(mime_content_type('.'.$variant->img_path), 'video') )
										<video src="{{$variant->img_path}}" controls></video>
									@else
										<img src="{{$variant->img_path}}">
									@endif
									</div>
								@endif

								@if ($variant->url != '')
									<div class="vote_youtube">
										<iframe src="https://www.youtube.com/embed/{{$variant->url}}?si=MCZJNtFw5QVXa45A" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
									</div>
								@endif
							</div>
						</label>
					</div>
				@endforeach

			</div>
		</main>
		<footer>
			<button id="editButton" type="submit">Проголосовать</button>
		</footer>
	</form>

@endsection
