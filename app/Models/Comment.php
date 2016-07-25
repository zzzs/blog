<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SoftDeletes as BinomialSoftDeletes;
use App\Traits\BaseModelScope;

class Comment extends Model {
	use BinomialSoftDeletes , BaseModelScope;

	protected $table = 'comments';
	protected $primaryKey = 'comment_id';

	protected $guarded = ['comment_id'];

    // 定义软删除的字段
	const DELETED_AT = 'is_del';
    // 配合 App\Traits\SoftDeletes
    const DELETED_SIGN = 1; // 已软删除标记,默认1
    const NOT_DELETED_SIGN = 0; // 未软删除标记,默认0
    protected function getDateFormat()
    {
        return 'U';
    }

	public function HasMe()
	{
		return $this->hasMany($this, 'pid', 'comment_id');
	}

}
