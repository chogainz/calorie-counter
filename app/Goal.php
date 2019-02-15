<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
	protected $fillable = ['calories_target', 'protein_percentage', 'carbohydrates_percentage', 'fat_percentage'];

	public function user()
    {

    	return $this->belongsTo(User::class);

    }
}
