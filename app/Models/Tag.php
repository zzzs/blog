<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model {

	protected $table = 'tags';
	protected $primaryKey = 'tag_id';
    public $timestamps = false;

    public function TagType()
    {
        return $this->belongsTo('App\Models\TagType','type');
    }

}
