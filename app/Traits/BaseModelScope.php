<?php

namespace App\Traits;

use App\Libs\CoreseekSearch;//全文检索类

trait BaseModelScope{

    /**
    * 使用 withOnly 只查询目标关联的部分字段
    * 使用 $topics = Topic::limit(2)->withOnly('user', ['username'])->get();
    *
    * @return builder
    */
    public function scopeWithOnly($query, $relation)
    {
        $relations = call_user_func_array([$this, "translateRelation"], func_get_args());
        return $query->with($relations);
    }

    /**
    * 使用 loadOnly 只查询目标关联的部分字段
    * 使用 $topics = Topic::limit(2)->loadOnly('user', ['username'])->get();
    *
    * @return model
    */
    public function scopeLoadOnly($query, $relation)
    {
        $relations = call_user_func_array([$this, "translateRelation"], func_get_args());
        return $this->load($relations);
    }

    /**
    * 转换"关系"
    *
    * @return array
    */
    private function translateRelation($query, $relation)
    {
        $relations = [];
        // 判断是否为单个
        if (is_string($relation)) {

            $columns = (array) func_get_arg(2);

            $relations = [$relation => function ($query) use ($columns){
                $query->select($columns);
            }];
        } else {
            foreach ((array) $relation as $key => $columns) {
                $relations[$key] = function ($query) use ($columns){
                    $query->select($columns);
                };
            }
        }
        return $relations;
    }

    /**
     * whereArray()：填补where()方法不能以数组方式传值的空白
     * @param  [Builder] $query [Builder]
     * @param  [array] $where [条件数组]
     * @return [Builder]        [Builder]
     */
    public function scopeWhereArray($query , $where)
    {
        if (!is_array($where) || empty($where)) {
            return $query;
        }
        foreach ($where as $key => $value) {
            if (!is_array($value)) {
                $query->where($key,$value);
            }else{
                $query->where($key,$value[0],$value[1]);
            }
        }
        return $query;
    }


    /**
     * CoreseekSearch():全文检索 或者 where(like)方式查询
     * @param  [Builder] $query  [Builder]
     * @param  [array] $search [查询数组]
     * @return [Builder]         [Builder]
     */
    public function scopeCoreseekSearch($query , $search)
    {
        if (!is_array($search) || empty($search)) {
            return $query;
        }
        //是否开启全文检索，暂时关闭
        $is_coreseek_search = false;
        //全文检索
        if ($is_coreseek_search) {
            $init_search=array('name'=>'','brand'=>'','keyword'=>'');
            if (isset($search['repo.name'])) {
                $init_search['name']=$search['repo.name'];
            }
            if (isset($search['spec.brand'])) {
                $init_search['brand']=$search['spec.brand'];
            }

            $coreseek  = new CoreseekSearch();
            //全文检索返回结果id集
            $ids = $coreseek->get($init_search);
            if (!empty($ids)) {
                $ids  =  explode ( "," ,  $ids );
            }
            $query->whereIn('repo.rid', $ids);

        }else{
            foreach ($search as $key => $value) {
                $query->where($key,'like','%'.$value.'%');
            }
        }

        return $query;
    }

    /**
    * 用于返回数据列表，当 $limit > 0 时，进行分页，否则取所有符合的数据
    *
    * @param int $limit 每页数量
    * @return Array
    */
    public function scopePaginateList($query, $limit = 0)
    {

        $limit = intval($limit);

        if ($limit <= 0){

            $paginate = [
                'data' => $query->get()->toArray()
            ];

        } else {

            //注意！！！ paginate 方法第二个参数是 $columns(默认为['*']) 表示将select的字段，使用[]参数表示不在此添加字段
            $paginate = $query->paginate($limit, [])->toArray();
            // unset($paginate['next_page_url']); // 这个链接参数不太对
            // unset($paginate['prev_page_url']);

        }

        return $paginate;
    }

}
