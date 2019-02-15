<?php

namespace App\Http\Controllers;

use App\User;

use App\Goal;

use App\Food;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;

use App\Http\Requests;

use App\Http\Controllers\Controller;

use Illuminate\Database\Eloquent\Model;


class FoodsController extends Controller
{
	
	public function __construct()
	{
		 $this->middleware('auth');
	}

 
    public function index()
    {
        //
        $foods = Food::all()->where('user_id', Auth::user()->id);

        return view('foods.index', compact('foods'));
    }

   
    public function create()
    {
        //
        return view('foods.create');
    }

  
    public function store(Request $request)
    {
        //
         $this->validate($request, [
             
        'food_name' => 'required|string:value',
        'protein_content' => 'required|integer',
        'carbohydrates_content' => 'required|integer',
        'fat_content' => 'required|integer',
    
        ]);

        $foods = new Food($request->all());
        $foods->user_id = Auth::user()->id;

        if($foods->protein_content +
        $foods->carbohydrates_content +
        $foods->fat_content <= 100){
        
        $foods->save();

        flash($foods->food_name . " Added Successfully", "success");
        return redirect()->action('FoodsController@index');


        } else {

        flash("All Food content must not excede 100", "danger");

        return back();

        }
    }

  
    public function show($id)
    {
        //
    }

    public function edit($id)
    {

        $foods = DB::table('foods')->where('id' , $id)->first();
        return view('foods.edit', compact('foods'));
    }


    public function update(Request $request, $id)
    {
		
         $this->validate($request, [
             
        'food_name' => 'required|string:value',
        'protein_content' => 'required|integer',
        'carbohydrates_content' => 'required|integer',
        'fat_content' => 'required|integer',
    
        ]);
    
        if($request->protein_content +
        $request->carbohydrates_content +
        $request->fat_content <= 100){
        
        DB::table('foods')->where('id' , $id)
            ->update(['food_name'=>$request->food_name,
            'protein_content'=>$request->protein_content,
            'carbohydrates_content'=>$request->carbohydrates_content,
            'fat_content'=>$request->fat_content]);


        flash("Updated Successfully", "success");
        return redirect()->action('FoodsController@index');
        

        } else {

        flash("All Food content must not excede 100", "danger");
        return back();

        }

    }


    public function destroy(Request $request, Food $food)
    {
   
        $food->update($request->all());
        $food->delete();
        flash('Food Deleted', 'Success');
        return redirect('foods');
 
    }
}
