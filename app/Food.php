<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
	protected $fillable = ['food_name', 'protein_content', 'carbohydrates_content', 'fat_content'];

	public function user()
    {

    	return $this->belongsTo(User::class);

    }
}
