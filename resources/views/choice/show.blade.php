@extends('layouts.main')

@section('content')
	<form method="POST" action="{{route('choice.update', $choice->id)}}" @if($order && Auth::user()->id == $order->expert) enctype="multipart/form-data" @endif>
		@csrf
		<input type="hidden" name="type" value="vote">
		<header>
			<h3 class="center">Голосование</h3>
		</header>

		<main class="choice_edit">

			@if($order && $order->is_done)
				<div class="expert_vote">
					<div class="expert_vote__head">
						<span>Ответ эксперта</span>
					</div>
					<div class="video">
						<video src="{{asset($order->video_path)}}#t=0.001" controls preload="metadata"></video>
					</div>
				</div>
			@endif

			<div class="votes">
				<div class="vote vote__head">
					<span>{{$choice->name}}</span>
				</div>

				@foreach($variants as $variant)
					<div class="vote">
						<label>
							@if ($choice->user != Auth::user()->id && !$my_vote)
								<input type="radio" name="vote" value="{{$variant->id}}">
							@endif

							<div class="vote_item">
								@if ($choice->user != Auth::user()->id && !$my_vote)
									<div class="radio"></div>
								@endif

								<div class="vote_info">
									@if ($variant->name != null)
										<div class="vote_name">
											<span>{{$variant->name}}</span>
										</div>
									@endif

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

									@if ($variant->description != null)
										<div class="vote_description">
											<span>{{$variant->description}}</span>
										</div>
									@endif
								</div>
							</div>

							@if($votes_array)
								@if(array_key_exists($variant->id, $votes_array))
									<div class="members_list">
										@foreach($votes_array[$variant->id] as $vote)
											@foreach($users as $user)
												@if($user->id == $vote->user)
													<div class="member">{{ $user->firstname }} {{ $user->surname }}</div>
												@endif
											@endforeach
										@endforeach
									</div>
								@endif
							@endif

						</label>
					</div>
				@endforeach

			</div>

		</main>
		@if ($choice->user != Auth::user()->id && !$my_vote)
			<footer>
				@if($order && Auth::user()->id == $order->expert)
					<div class="expert_answer">
						<div class="input-file">
							<input type="file" class="choice_media" placeholder="Медиа" name="expert_answer"
								   accept="video/*">
							<div class="icon">
								<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
									 stroke-width="1.5"
									 stroke="currentColor" class="w-6 h-6">
									<path stroke-linecap="round" stroke-linejoin="round"
										  d="M7.5 7.5h-.75A2.25 2.25 0 0 0 4.5 9.75v7.5a2.25 2.25 0 0 0 2.25 2.25h7.5a2.25 2.25 0 0 0 2.25-2.25v-7.5a2.25 2.25 0 0 0-2.25-2.25h-.75m0-3-3-3m0 0-3 3m3-3v11.25m6-2.25h.75a2.25 2.25 0 0 1 2.25 2.25v7.5a2.25 2.25 0 0 1-2.25 2.25h-7.5a2.25 2.25 0 0 1-2.25-2.25v-.75"/>
								</svg>
							</div>
							<span>Загрузите видео-ответ</span>
						</div>
					</div>
				@endif

				<button id="editButton" type="submit">Проголосовать</button>
			</footer>
		@endif
	</form>

@endsection
