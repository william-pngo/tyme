<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Item;

class GenreController extends Controller
{
    public function filterByGenre(Request $request){

    	$genre_id = $request->input("genre_id");

    	if ($genre_id !== null) {

    		$genre_id = $genre_id + 1;
    	
    		$items = Item::where('genre_id', $genre_id)->get();

    		return view("items.catalog", compact('items'));

    	} else if ($genre_id == null) {

    		return redirect('/catalog');

    	} else {

    		return redirect('/catalog');
    	}
    }
}
