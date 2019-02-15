<?php

namespace App\Http\Controllers;

use App\User;

use App\Goal;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB;

use App\Http\Requests;

use App\Http\Controllers\Controller;

use Illuminate\Database\Eloquent\Model;


class GoalsController extends Controller
{
	
	public function __construct()
	{
		 $this->middleware('auth');
	}
	
    public function index()
    {		

        if(IsGoalSet(Auth::user()->id)){
            
            $goals= DB::table('goals')->where('user_id' , Auth::user()->id)->first();
            
            $userTargets = setTargets($goals);
                
            return view('goals.edit', compact('goals','userTargets'));
            
        } else {
            
            return view('goals.create');
            
        }
        
    }


    public function create(Request $request)
    {

        return view('goals.create');
    }


    public function store(Request $request, Goal $goals)
    {
     
     if(IsGoalSet(Auth::user()->id)){
                        
        return back();
        
        } else {
            
        $this->validate($request, [
             
        'calories_target' => 'required|integer',
        'protein_percentage' => 'required|integer',
        'carbohydrates_percentage' => 'required|integer',
        'fat_percentage' => 'required|integer',
    
        ]);
        $goals = new Goal($request->all());
        $goals->user_id = Auth::user()->id;
        $userTargets = setTargets($goals);
            
            
        if($goals->protein_percentage +
           $goals->carbohydrates_percentage +
           $goals->fat_percentage == 100){
            
        $goals->save();
        
        flash("Goals Set for " . Auth::user()->name, "success");
        return view('goals.edit',compact('goals','userTargets'));   
        
            } else {
        
                    
        flash("Macronutrient Total must equal 100", "danger");
        return view('goals.create');    
                
            }
        }
    }
    

    public function show($id)
    {
        //
    }

    public function edit($id)

    {

        dd('hit');

    }


    public function update(Request $request)
    {

        $goals= DB::table('goals')->where('user_id' , Auth::user()->id)->first();
        
        $this->validate($request, [
             
        'calories_target' => 'required|integer',
        'protein_percentage' => 'required|integer',
        'carbohydrates_percentage' => 'required|integer',
        'fat_percentage' => 'required|integer',
    
        ]);
        
        $goals = new Goal($request->all());
        $goals->user_id = Auth::user()->id;
        $userTargets = setTargets($goals);
                

         if($goals->protein_percentage + $goals->carbohydrates_percentage + $goals->fat_percentage == 100){

        DB::table('goals')->where('user_id' , Auth::user()->id)
           ->update(['calories_target'=>$goals->calories_target,
                     'protein_percentage'=>$goals->protein_percentage,
                     'carbohydrates_percentage'=>$goals->carbohydrates_percentage,
                     'fat_percentage'=>$goals->fat_percentage]);

        
        flash("Goals Updated for " . Auth::user()->name , "success");
        return redirect()->action('GoalsController@index');

        } else {

        flash("Macronutrient Total must equal 100", "danger");
        return view('goals.edit', compact('goals', 'userTargets'));
        
        }
    }


    public function destroy($id)
    {
        //
    }
}
