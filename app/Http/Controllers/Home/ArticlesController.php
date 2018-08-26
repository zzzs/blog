<?php namespace App\Http\Controllers\Home;

use App\Models\Article;
use App\Http\Controllers\Home\BaseController;
use Illuminate\Routing\Route;


class ArticlesController extends BaseController {

    public function show($id)
    {
        $base_data = $this->base_index();
        $article = Article::with([
            'Comments'=>function($q){
                $q->where('status', '=', 1)
                    ->with(['Guest'=>function($q){
                        $q->select('id', 'nickname', 'website');
                    }])
                    ->orderByRaw('pid, created_at');
            },
            'Recommends'])->find($id);

      	//前一页
        $prew = Article::select('article_id', 'title')
        ->where('cate_id', $article->cate_id)
        ->where('article_id', '<', $id)->limit(1)
        ->orderBy('article_id', 'desc')->first();
        if (empty($prew)) {
            $prew = Article::select('article_id', 'title')
            ->where('article_id', '<', $id)->limit(1)
            ->orderBy('article_id', 'desc')->first();
        }
        //后一页
        $next = Article::select('article_id', 'title')
        ->where('cate_id', $article->cate_id)
        ->skip($id)->take(1)->first();
        if (empty($next)) {
            $next = Article::select('article_id', 'title')
            ->skip($id)->take(1)->first();
        }

        return view(
            'home.articles.show',
            [
                'article'=>$article,
                 // 'meta_keywords'=>substr($article['body'], 0, 80),
                'meta_desc'=>$article['title'],
                'prew'=>$prew,
                'next'=>$next
            ]+$base_data
        );
    }

}
