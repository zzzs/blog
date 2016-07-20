<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TagType extends Model {

	protected $table = 'tag_types';
    public $timestamps = false;

	public function Tags()
	{
		return $this->hasMany('App\Models\Tags', 'type', 'id');
	}

}
