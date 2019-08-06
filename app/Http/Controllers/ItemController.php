<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Item;
use \App\User;
use \App\Order;
use \App\Genre;
use \App\Status;
use Illuminate\Support\Facades\Validator;
use Session;
use Auth; //We can use auth::controller here

class ItemController extends Controller
{
    public function showItems(){
    	$items = Item::all();
        $genres = Genre::all();

    	return view("items.catalog", compact('items', 'genres'));
    }

    public function showAddItemForm(){
    	return view("items.add_item_form");
    }

    public function addItem(Request $request){

        $rules = array(
            "name" => "required",
            "description" => "required",
            "image" => "required|mimes:jpeg, png, jpg, gif, bmp, svg|max:2048",
            'url' => ['required', 'regex:/(https|http):\/\/(?:www\.)?youtube.com\/embed\/[A-z0-9]+/'],
        );

        $this->validate($request, $rules);

        $new_item = new Item;
        $new_item->name = $request->name;
        $new_item->description = $request->description;
        $new_item->genre_id = $request->genre_id;
        $new_item->country_id = $request->country_id;
        $new_item->url = $request->url;

    	$image = $request->file('image');
    	$image_name = time() . "." . $image->getClientOriginalExtension();
    	$destination = "images/";
    	$image->move($destination, $image_name);
    	$new_item->img_path = $destination.$image_name;

    	$new_item->save();

        Session::flash("message", "$request->name Has Been Added To The Catalog.");
    	return redirect('/catalog');
    }

    public function deleteItem($id){
        $item=Item::find($id);
        unlink($item->img_path);
        $item->delete();

        Session::flash("message", "$item->name Has Been Deleted From The Catalog.");
        return redirect('/catalog');
    }

    public function editItem($id, Request $request){
        $item=Item::find($id);

        $rules = array(
            "name" => "required",
            "description" => "required",
            "image" => "nullable|mimes:jpeg, png, jpg, gif, bmp, svg|max:2048",
            'url' => ['sometimes', 'regex:/(https|http):\/\/(?:www\.)?youtube.com\/embed\/[A-z0-9]+/'],
        );

        $this->validate($request, $rules);

        $item->name = $request->name;
        $item->description = $request->description;
        $item->genre_id = $request->genre_id;
        $item->country_id = $request->country_id;

        if ($request->file('image') != null) {

           unlink($item->img_path);
           $image = $request->file('image');
           $image_name = time() . "." . $image->getClientOriginalExtension();
           $destination = "images/";
           $image->move($destination, $image_name);
           $item->img_path = $destination.$image_name;
       }

       if ($request->url('url')) {
           $item->url = $request->url;
       }

        $item->save();

        Session::flash("message", "$item->name Has Been Edited In The Catalog.");
        return redirect('/catalog');
    }

    public function showAllUsers(){

        $users = User::all();

        return view("items.all_users", compact('users'));
    }

    public function filterByUser(Request $request){

        $user_id = $request->input("user_id");

        if ($user_id !== null) {
            $orders = Order::where('user_id', $user_id)->get();
        } else {
            $orders = Order::all();
        }

        return view("items.all_requests", compact('orders'));
    }

    public function filterByStatus(Request $request){

        $status_id = $request->input("status_id");

        if ($status_id !== null) {
            $orders = Order::where('status_id', $status_id)->get();
        } else {
            $orders = Order::all();
        }

        return view("items.all_requests", compact('orders'));
    }

    public function userDetails($id){

        $user = User::find($id);

        return view("items.user_details", compact('user'));
    }

    public function demoteUserRole($id){
        $user = User::find($id);
        $user->role_id = 1;
        $user->save();

        return redirect("/admin/showAllUsers");
    }

    public function promoteUserRole($id){
        $user = User::find($id);
        $user->role_id = 2;
        $user->save();

        return redirect("/admin/showAllUsers");
    }

    public function removeUser($id){
        $user = User::find($id);
        unlink("../public".$user->img_path);
        $user->delete();
        return redirect("/admin/showAllUsers");
    }

    public function reserveItem($id){

        $new_order = new Order;
        $new_order->item_id = $id;
        $new_order->user_id = Auth::user()->id;
        $new_order->status_id = 1;
        $new_order->save();

        $item = Item::find($id);

        Session::flash("message", "You Have Requested $item->name. Check Your 'Reservations' Page For Approval Status");
        return redirect('/catalog');

    }

    public function showAllOrders(){
        $orders = Order::all();

        return view("items.all_requests", compact('orders'));
    }

    public function showOrders(){
        $id = Auth::user()->id;

        $orders = Order::where('user_id', $id)->get();

        return view("items.all_requests", compact('orders'));
    }

    public function approveOrderStatus($id){
        $order = Order::find($id);

        $order->status_id = 2;
        $order->save();

        return redirect('/admin/showAllOrders');
    }

    public function rejectOrderStatus($id){
        $order = Order::find($id);

        $order->status_id = 3;
        $order->save();

        return redirect('/admin/showAllOrders');
    }
    
    public function deleteOrder($id){
        $order = Order::find($id);

        $order->delete();

        return redirect('/admin/showAllOrders');

    }

    public function cancelOrderStatus($id){
        $order = Order::find($id);

        $order->status_id = 4;
        $order->save();

        return redirect('/myOrders');
    }

    public function returnItem($id){
        $order = Order::find($id);
        $id = $order->item_id;
        $item = Item::find($id);
        $order->status_id = 5;
        $order->save();

        Session::flash("message", "You Have Returned The Item $item->name. Please Wait 24 Hours Before Reserving It Again.");

        return redirect('/catalog');
    }

    public function showProfile($id){
        $users = User::find($id);
        
        return view('items.profile', compact('users'));
    }

    public function deleteProfile($id){
        $user = User::find($id);
        unlink("../public".$user->img_path);
        $user->delete();
        return redirect('/');
    }

    public function editDetails($id, Request $request){

        $user = User::find($id);

        $rules = array(
            "email" => "required",
            "gender_id" => "required",
            "image" => "nullable|mimes:jpeg, png, jpg, gif, bmp, svg|max:2048",
        );

        $this->validate($request, $rules);

        $user->name = $request->name;
        $user->lastname = $request->lastname;
        $user->email = $request->email;
        $user->date_of_birth = $request->date;
        $user->description = $request->description;
        $user->gender_id = $request->gender_id;

        if ($request->file('image') != null) {

           unlink("../public".$user->img_path);
           $image = $request->file('image');
           $image_name = time() . "." . $image->getClientOriginalExtension();
           $destination = "images/";
           $image->move($destination, $image_name);
           $user->img_path = "/".$destination.$image_name;
       }

        $user->touch();
        
        if (Auth::user()->role_id == 1) {
            return view('items.profile');
        } else {
            return view('items.user_details', compact('user'));
        }
    }

}
