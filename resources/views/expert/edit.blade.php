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
				<div class="expert">
					<label>
						<input type="radio" name="expert" value="2">

						<div class="expert_line">
							<div class="expert_ava" style="background-image: url('https://upload.wikimedia.org/wikipedia/commons/thumb/7/7b/Wylsacom_%D0%BD%D0%B0_%D0%92%D0%B8%D0%B4%D1%84%D0%B5%D1%81%D1%82_2018_%D0%B2_%D0%9C%D0%BE%D1%81%D0%BA%D0%B2%D0%B5_%28cropped%29.jpg/640px-Wylsacom_%D0%BD%D0%B0_%D0%92%D0%B8%D0%B4%D1%84%D0%B5%D1%81%D1%82_2018_%D0%B2_%D0%9C%D0%BE%D1%81%D0%BA%D0%B2%D0%B5_%28cropped%29.jpg');"></div>
							<div class="expert_data">
								<div class="expert_name">Валентин Петухов</div>
								<div class="expert_nickname">#wylsacom</div>
							</div>
							<div class="expert_price">1 000 Wö</div>
						</div>
					</label>
				</div>

				<div class="expert nomoney">
					<div class="nomoney_message"><span>Не достаточно средств на балансе</span></div>
					<label>
						<div class="expert_line">
							<div class="expert_ava" style="background-image: url('https://upload.wikimedia.org/wikipedia/commons/thumb/7/7b/Wylsacom_%D0%BD%D0%B0_%D0%92%D0%B8%D0%B4%D1%84%D0%B5%D1%81%D1%82_2018_%D0%B2_%D0%9C%D0%BE%D1%81%D0%BA%D0%B2%D0%B5_%28cropped%29.jpg/640px-Wylsacom_%D0%BD%D0%B0_%D0%92%D0%B8%D0%B4%D1%84%D0%B5%D1%81%D1%82_2018_%D0%B2_%D0%9C%D0%BE%D1%81%D0%BA%D0%B2%D0%B5_%28cropped%29.jpg');"></div>
							<div class="expert_data">
								<div class="expert_name">Валентин Петухов</div>
								<div class="expert_nickname">#wylsacom</div>
							</div>
							<div class="expert_price">11 000 Wö</div>
						</div>
					</label>
				</div>
			</div>
		</main>
		<footer>
			<button id="editButton" type="submit">Продолжить</button>
		</footer>
	</form>

@endsection
