<?php

namespace App\Http\Controllers;

use App\Models\Deposit;
use App\Http\Requests\StoreDepositRequest;
use App\Http\Requests\UpdateDepositRequest;
use App\Models\Wallet;
use Illuminate\Support\Facades\Auth;

class DepositController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
		$user_id = Auth::user()->id;
		$balance = Wallet::where('user_id', $user_id)->first()->balance;

		return view('deposit.index', compact('balance'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDepositRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Deposit $deposit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Deposit $deposit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDepositRequest $request, Deposit $deposit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Deposit $deposit)
    {
        //
    }
}
