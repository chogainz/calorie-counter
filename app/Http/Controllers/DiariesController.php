<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\App;

use Illuminate\Support\Facades\Input;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;

use Illuminate\Database\Eloquent\Model;

use App\Calendar;

use App\User;

use App\Food;

Use App\Goal;

use App\Diary;

use URL;


class DiariesController extends Controller
{
	
	public function __construct()
	{
		 $this->middleware('auth');
	}


    public function index()
    {
		
        $month = isset($_GET['month']) && !empty($_GET['month']) ? $_GET['month'] : '';
        $year = isset($_GET['year']) && !empty($_GET['year']) ? $_GET['year'] : '';
        $calendar = new Calendar(URL::to('/') . "/diaries");

        $calories_results = monthlyCalories(Auth::user()->id, $calendar->thisMonth()); 
        $calendar_display = $calendar->show();

        return view('diaries.index', compact('calendar_display', 'calories_results'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $foods = new Diary($request->all());
        $foods->food_id = $request->id;
        $foods->save();

        flash($foods->food_name . " Added Successfully", "success");
        
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $food_grams = "";
        $user_id = Auth::user()->id;
        $date_consumed = $id;

        $allFood = DB::table('foods')
        ->leftJoin('diaries', 'foods.id', '=', 'diaries.food_id')
        ->select('diaries.date_consumed',
            'foods.food_name','foods.id',
            'diaries.food_grams',
            'foods.protein_content',
            'foods.carbohydrates_content',
            'foods.fat_content')
        ->where('diaries.date_consumed', $date_consumed)->where('diaries.user_id', $user_id)->get();

        
        $total_calories = DailyCalories($allFood);
        $foodSelection = DB::table('foods')->where('user_id' , $user_id)->get();
        
        return view('diaries.show', compact('foodSelection',
                                            'food_grams',
                                            'date_consumed',
                                            'user_id','allFood',
                                            'total_calories'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $food_selection = DB::table('foods')->where('user_id' , Auth::user()->id)->get();

        $diaries = DB::table('foods')
        ->leftJoin('diaries', 'foods.id', '=', 'diaries.food_id')
        ->select('foods.food_name','diaries.food_grams', 'diaries.food_id','diaries.date_consumed', 'diaries.id')
        ->where('diaries.food_id', $id)->first();

        return view('diaries.edit', compact('diaries', 'food_selection'));
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
        DB::table('diaries')->where('id' , $id)->update(['food_grams'=> $request->food_grams]);
        flash("Updated Successfully", "success");

        return redirect('diaries');
       
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
