<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Receipt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BusinessPagesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function home()
	{
        return view('business.home');
	}

	/**
	 * Display business promotions
	 *
	 * @return Response
	 */
	public function promotions()
	{
        $promotions = \Auth::user()->promotions;
        return view('business.promotions', compact('promotions'));
	}

	/**
	 * Show the form for creating a new promotion.
	 *
	 * @return Response
	 */
	public function createPromotion()
	{
        return view('business.create_promotion');
	}

	/**
	 * Display the specified resource.
	 *
	 * @return Response
	 */
	public function receipts()
	{
        $receipts = Receipt::where('afm', '=', Auth::user()->afm)->paginate(30);
		return view('business.receipts', compact('receipts'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
