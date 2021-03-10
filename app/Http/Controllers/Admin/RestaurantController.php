<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Restaurant;
use App\Category;

class RestaurantController extends Controller
{

    private $restaurantValidation = [
        'name' => 'required',
        'email' => 'required',
        'address' => 'required',
        'phone' => 'required',
        'description' => 'required',
        'p_iva' => 'required',
        'photo' => 'image',
        'photo_jumbo' => 'image'

    ] ;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.restaurants.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();

        return view('admin.restaurants.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate($this->restaurantValidation);


        $data = $request->all();

        $newRestaurant = new Restaurant();
        $data['user_id'] = Auth::id();
        $data["slug"] = Str::slug($data["name"]);
        
        if(!empty($data['photo'])) {
            $data['photo'] = Storage::disk('public')->put('img', $data['photo']);
        }
        if(!empty($data['photo_jumbo'])) {
            $data['photo_jumbo'] = Storage::disk('public')->put('img', $data['photo_jumbo']);
        }

        $newRestaurant->fill($data);

        $newRestaurant->save();
        

        return redirect()
               ->route('admin.restaurants.index')
               ->with('message' , 'Il ristorante' . $newRestaurant->name . 'è stato creato con successo');
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
