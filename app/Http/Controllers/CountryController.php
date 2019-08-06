<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Item;

class CountryController extends Controller
{
    public function filterByCountry(Request $request){

    	$country_id = $request->input("country_id");

    	if ($country_id !== null) {

    		$country_id = $country_id + 1;
    	
    		$items = Item::where('country_id', $country_id)->get();

    	} else if ($country_id == null) {

    		$items = Item::all();

    	} else {

    		$items = Item::all();
    	}
    	
    	return view("items.catalog", compact('items'));
    }
}
