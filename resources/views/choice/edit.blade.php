@extends('layouts.main')

@section('content')
	<form method="POST" action="{{route('choice.update', $choice->id)}}">
		@csrf
		<header>
			<h3 class="left">Эксперты</h3>
			<div class="right balance">{{$balance}} Wö</div>
		</header>

		<main class="choice_edit">

			<div class="experts">
				<div class="expert expert__head">
					<span>Выберите эксперта</span>
				</div>

				@foreach($experts as $expert)
					<div class="expert @if($expert->price > $balance) nomoney @endif">
						@if($expert->price > $balance)
							<div class="nomoney_message"><span>Не достаточно средств на балансе</span></div>
						@endif
						<label>
							<input type="radio" name="expert" value="{{$expert->id}}">

							<div class="expert_line">
								<div class="expert_ava" style="background-image: url({{$expert->img_path}});"></div>
								<div class="expert_data">
									<div class="expert_name">{{$expert->firstname}} {{$expert->surname}}</div>
									<div class="expert_nickname">{{'@'.$expert->nickname}}</div>
								</div>
								<div class="expert_price">{{number_format($expert->price, 0, '', ' ')}} Wö</div>
							</div>
						</label>
					</div>
				@endforeach
			</div>
		</main>
		<footer>
			<button id="editButton" type="submit">Продолжить</button>
		</footer>
	</form>

@endsection
