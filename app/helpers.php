<?php 

use App\Diary;
use App\User;
use App\Goal;
use App\Food;
use Illuminate\Database\Eloquent\Model;

function flash($message, $level = 'info'){


	Session()->flash('flash_message', $message);
	Session()->flash('flash_message_level', $level);

}

class UserResults extends Illuminate\Database\Eloquent\Model {}
class MonthlyCaloriesResults extends Illuminate\Database\Eloquent\Model {}

function IsGoalSet($id){
	
	if($set= DB::table('goals')->where('user_id' , $id)->exists()==null){
		
		return false;
		
	}	else {
		
		return true;
		
	}
}

function setTargets($userInput){

		
	$protein_target = $userInput->calories_target / 100 * $userInput->protein_percentage / 4;
	$carbohydrates_target = $userInput->calories_target / 100 * $userInput->carbohydrates_percentage / 4;
	$fat_target = $userInput->calories_target / 100 * $userInput->fat_percentage / 9;

	$userResults = new UserResults();
	
	$userResults->protein_target = round($protein_target);
	$userResults->carbohydrates_target = round($carbohydrates_target);
	$userResults->fat_target = round($fat_target);
	
	return $userResults;
	
}

function DailyCalories($allFood){


	$protein_total_calories = 0;
	$carbohydrates_total_calories = 0;
	$fat_total_calories = 0;

	foreach($allFood as $food){

		$protein_total_calories +=  $food->food_grams / 100 *  $food->protein_content * 4;
		$carbohydrates_total_calories +=  $food->food_grams / 100 *  $food->carbohydrates_content * 4;
		$fat_total_calories +=  $food->food_grams / 100 *  $food->fat_content * 9;

	}

	$total_food_calories = $protein_total_calories +
	$carbohydrates_total_calories +
	$fat_total_calories;

	return $total_food_calories;

}

function MonthlyCalories($user, $month) {

        $query = DB::table('diaries')
            ->leftJoin('foods', 'diaries.food_id', '=', 'foods.id')
            ->leftJoin('users', 'foods.user_id', '=', 'users.id')
			->leftJoin('goals', 'foods.user_id', '=', 'goals.user_id')
            ->whereMonth('diaries.date_consumed', '=', $month)
            ->where('foods.user_id' , $user)
            ->select(
                'date_consumed',
                \DB::raw('sum(carbohydrates_content / 100 * food_grams * 4) as carbohydrates'),
                \DB::raw('sum(fat_content / 100 * food_grams * 9) as fat'),
                \DB::raw('sum(protein_content / 100 * food_grams * 4) as protein'),
                \DB::raw('sum(
                    (carbohydrates_content / 100 * food_grams * 4) + 
                    (fat_content / 100 * food_grams * 9) +
                    (protein_content / 100 * food_grams * 4)
                ) as daily_calories')
            )
            ->groupBy('date_consumed')
            ->get();

	$protein_total  = 0;
    $carbohydrates_total = 0;
    $fat_total = 0;
    $total_food_calories = 0;
    $current_date = 0;

    $protein_total_daily  = 0;
    $carbohydrates_total_daily = 0;
    $daily_calories_target = 0;
    $fat_total_daily = 0;

    $users = User::all()->where('id', $user)->first();
    $diaries = Diary::all()->first();
	
   	$entryDates = $users->diary->where('user_id', $user)->groupBy('date_consumed');

    foreach($entryDates as $entry){

    	foreach($entry as $value){
			
			
    		$all_food_data = $diaries->food->where('id', $value->food_id)->first();
			
    		$value->food_name = $all_food_data->food_name;
    		$value->protein = $all_food_data->protein_content;
    		$value->carbohydrates = $all_food_data->carbohydrates_content;
    		$value->fat = $all_food_data->fat_content;

    		$value->protein_total_calories =  $value->food_grams / 100 *  $value->protein * 4;
    		$value->carbohydrates_total_calories =  $value->food_grams / 100 *  $value->carbohydrates * 4;
    		$value->fat_total_calories =  $value->food_grams / 100 *  $value->fat * 9;

    		$total_food_calories += $value->protein_total_calories +
    		$value->carbohydrates_total_calories +
    		$value->fat_total_calories;

    	}

    	// TOTAL DAILY CALORIES

    	$entry->add(['totalFoodCalories' =>$total_food_calories]);
    	$total_food_calories = 0;

    }

    $currentMonth = DB::table('diaries')
    ->leftJoin('foods', 'diaries.food_id', '=', 'foods.id')
    ->leftJoin('goals', 'foods.user_id', '=', 'goals.user_id')
    ->leftJoin('users', 'goals.user_id', '=', 'users.id')
    ->select('diaries.date_consumed',
        'foods.food_name','foods.id', 
        'foods.protein_content', 
        'foods.carbohydrates_content',
        'foods.fat_content',
        'diaries.food_grams',
        'goals.calories_target',
        'goals.protein_percentage',
        'goals.Carbohydrates_percentage',
        'goals.fat_percentage')
    ->whereMonth('diaries.date_consumed', '=', $month)->
    where('foods.user_id' , $user)->get();


    foreach ($currentMonth as $key => $value) {

   		//PROTEIN TOTAL FOR EACH FOOD
        $protein_total +=  $value->food_grams / 100 *  $value->protein_content;
        $carbohydrates_total +=  $value->food_grams / 100 *  $value->carbohydrates_content;
        $fat_total +=  $value->food_grams / 100 *  $value->fat_content;
        $daily_calories_target = $value->calories_target;

    }

        $protein_monthly_calories = $protein_total * 4;
        $carbohydrates_monthly_calories = $carbohydrates_total * 4;
        $fat_monthly_calories = $fat_total * 9;
        $total_monthly_calories = $protein_monthly_calories + $carbohydrates_monthly_calories + $fat_monthly_calories; 

        $monthlyCaloriesResults = new MonthlyCaloriesResults();

        $monthlyCaloriesResults->monthlyCaloriesTotal = $total_monthly_calories;
        $monthlyCaloriesResults->dailyCaloriesTarget = $daily_calories_target;

        $monthlyCaloriesResults->dailyTotals = $entryDates;

        return  $monthlyCaloriesResults;
}
