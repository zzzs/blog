<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SoftDeletes as BinomialSoftDeletes;
use App\Traits\BaseModelScope;

class Article extends Model {
    // 使用修改过的二项软删除
    use BinomialSoftDeletes , BaseModelScope;

	protected $table = 'articles';
	protected $primaryKey = 'article_id';
    protected $guarded = ['article_id'];
    // 定义软删除的字段
    const DELETED_AT = 'is_del';
    // 配合 App\Traits\SoftDeletes
    const DELETED_SIGN = 1; // 已软删除标记,默认1
    const NOT_DELETED_SIGN = 0; // 未软删除标记,默认0

    // 更新时间字段
    public function getDates()
    {
    	return [];
    }

    protected function getDateFormat()
    {
        return 'U';
    }

	public function Comments()
	{
		return $this->hasMany('App\Models\Comment', 'article_id', 'article_id');
	}

	public function Tag()
	{
		return $this->hasOne('App\Models\Tag', 'tag_id', 'cate_id');
	}

    public function Recommends()
    {
        return $this->belongsToMany($this, 'recommends', 'article_id', 're_article_id')
        ->withPivot('recommend_id');
    }

}
