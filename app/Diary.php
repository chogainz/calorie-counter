<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Diary extends Model
{
	protected $fillable = ['food_grams', 'user_id', 'food_id', 'date_consumed'];

		public function user()
    {

    	return $this->belongsTo(User::class);

    }

    	public function food()
    {

    	return $this->belongsTo(Food::class);

    }
}
