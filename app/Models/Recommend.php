<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recommend extends Model {

	protected $table = 'recommends';
	protected $primaryKey = 'recommend_id';
    public $timestamps = false;
	protected $guarded = ['recommend_id'];

}
