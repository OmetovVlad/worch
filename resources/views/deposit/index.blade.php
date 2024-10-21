@extends('layouts.main')

@section('content')
	<form method="POST" action="">
		@csrf

		<header>
			<h3 class="left">Пополнить баланс</h3>
			<div class="right balance">{{$balance}} Wö</div>
			<div class="right deposit"><a href="#">Пополнить</a></div>
		</header>

		<main class="deposit_page">
			<input name="name" placeholder="Сумма пополнения" class="deposit_sum" type="number">

		</main>
		<footer>
			<button id="depositButton" type="submit" disabled>Пополнить</button>
		</footer>
	</form>

@endsection
