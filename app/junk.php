<?php 

function flash($message, $level = 'info'){


	Session()->flash('flash_message', $message);
	Session()->flash('flash_message_level', $level);


}


class UserResults extends Illuminate\Database\Eloquent\Model {}

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

function MonthlyCalories($month, $user){

	$protein_total  = 0;
    $carbohydrates_total = 0;

    $currentMonth = DB::table('foods')
    ->leftJoin('diaries', 'foods.id', '=', 'diaries.food_id')
    ->leftJoin('goals', 'foods.user_id', '=', 'goals.user_id')
    ->leftJoin('users', 'goals.user_id', '=', 'users.id')
    ->select('diaries.date_consumed',
        'foods.food_name','foods.id', 
        'foods.protein_content', 
        'foods.carbohydrates_content',
        'foods.fat_content',
        'diaries.food_grams',
        'users.name',
        'goals.calories_target',
        'goals.protein_percentage',
        'goals.Carbohydrates_percentage',
        'goals.fat_percentage')
    ->whereMonth('diaries.date_consumed', '=', $month)->
    where('foods.user_id' , $user)->groupBy('diaries.date_consumed')->get();

    echo 'User: ' . $currentMonth[0]->name . '<br/>';
    echo 'Daily Calories : ' . $currentMonth[0]->calories_target . '<br/>';
    echo 'Protein %: ' . $currentMonth[0]->protein_percentage . '<br/>';
    echo 'Carbohydrates %: ' . $currentMonth[0]->Carbohydrates_percentage . '<br/>';
    echo 'Fat %: ' . $currentMonth[0]->fat_percentage . '<br/><br/>';

    foreach ($currentMonth as $key => $value) {

        echo 'Name: ' . $value->food_name . '<br/>';
        echo 'Date consumed: ' . $value->date_consumed . '<br/>';
        echo 'Protein content: ' . $value->protein_content . '<br/>';
        echo 'Carbohydrates content: ' . $value->carbohydrates_content . '<br/>';
        echo 'Fat content: ' . $value->fat_content . '<br/>';
        echo 'Number of Grams consumed: ' . $value->food_grams . '<br/>';
        echo 'Protein total Grams: ' . $value->food_grams / 100 *  $value->protein_content . '<br/><br/>';

        $protein_total +=  $value->food_grams / 100 *  $value->protein_content . '<br/><br/>';
        $carbohydrates_total +=  $value->food_grams / 100 *  $value->carbohydrates_content . '<br/><br/>';

    }

        $protein_monthly_calories = $protein_total * 4;
        $carbohydrates_monthly_calories = $carbohydrates_total * 4;
        $toal_monthly_calories = ($protein_monthly_calories + $carbohydrates_monthly_calories);

        echo 'protein total this month (grams): ' . $protein_total . '<br/>';
        echo 'carbohydrates total this month (grams): ' . $carbohydrates_total . '<br/>';

        echo 'P calories Month: ' . $protein_monthly_calories . '<br/>';
        echo 'C calories Month: ' . $carbohydrates_monthly_calories . '<br/>';
        echo 'Total monthly calories: ' . $toal_monthly_calories  . '<br/>';




}

/////////////// VERY USEFULL
      $sql = "select date_consumed, 
                sum(carbohydrates_content / 100 * food_grams * 4) as carbohydrates, 
                sum(fat_content / 100 * food_grams * 9) as fat, 
                sum(protein_content / 100 * food_grams * 4) as protein,

                sum(
                    (carbohydrates_content / 100 * food_grams * 4) + 
                    (fat_content / 100 * food_grams * 9) +
                    (protein_content / 100 * food_grams * 4)
                ) as calories

            from `diaries` 
                left join `foods` on `diaries`.`food_id` = `foods`.`id` 
                left join `users` on `foods`.`user_id` = `users`.`id`
                where month(`diaries`.`date_consumed`) = 09 and `users`.`id` = 2

            group by date_consumed";

        $results = \DB::select(\DB::raw($sql));

        $month = '09';
        $user = 2;

        $query = DB::table('diaries')
            ->leftJoin('foods', 'diaries.food_id', '=', 'foods.id')
            ->leftJoin('users', 'foods.user_id', '=', 'users.id')
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
                ) as calories')
            )
            ->groupBy('date_consumed')
            ->get();

        dd($results);