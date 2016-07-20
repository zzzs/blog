@extends('admin.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default">
        <div class="panel-heading">文章
          <a href="{{ URL('admin/articles/create') }}" class="btn btn-xs btn-primary">新增</a>
        </div>

        <div class="panel-body">
          <table class="table table-striped" style="table-layout:fixed">
            <tr class="row">
              <th class="col-lg-1">文章ID</th>
              <th class="col-lg-5">标题</th>
              <th class="col-lg-1">分类</th>
              <th class="col-lg-2">内容</th>
              <th class="col-lg-1">评论</th>
              <th class="col-lg-1">编辑</th>
              <th class="col-lg-1">删除</th>
            </tr>
            @foreach ($articles as $article)
            @if ($article->is_del == 0)
            <tr class="row">
              <td class="col-lg-1">
                {{ $article->article_id }}
              </td>
              <td class="col-lg-5">
                {{ $article->title }}
              </td>
              <td class="col-lg-1">
                {{ $article->Tag->name }}
              </td>
              <td  class="col-lg-2">
                {{ $article->body }}
              </td>
              <td class="col-lg-1">
                @if (count($article->comments->toArray()) > 0)
                <a href="{{ URL('admin/articles/comments/'.$article->article_id) }}" class="btn btn-xs btn-info">查看</a>
                @else
                <del>冷门</del>
                @endif
              </td>
              <td class="col-lg-1">
                <a href="{{ URL('admin/articles/'.$article->article_id.'/edit') }}" class="btn btn-xs btn-success">编辑</a>
              </td>
              <td class="col-lg-1">
                <form action="{{ URL('admin/articles/'.$article->article_id) }}" method="POST" style="display: inline;">
                  <input name="_method" type="hidden" value="DELETE">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <button type="submit" class="btn btn-xs btn-danger">删除</button>
                </form>
              </td>
            </tr>
            @else
            <tr class="row">
              <td class="col-lg-1">
                <del>{{ $article->article_id }}</del>
              </td>
              <td class="col-lg-5">
                <del>{{ $article->title }}</del>
              </td>
              <td class="col-lg-1">
                {{ $article->Tag->name }}
              </td>
              <td class="col-lg-2">
                {{ $article->body }}
              </td>
              <td class="col-lg-1">
                @if (count($article->comments->toArray()) > 0)
                <a href="{{ URL('admin/articles/comments/'.$article->article_id) }}" class="btn btn-xs btn-info">查看</a>
                @else
                <del>冷门</del>
                @endif
              </td>
              <td class="col-lg-1">
                <del>编辑</del>
              </td>
              <td class="col-lg-1">
                <form action="{{ URL('admin/articles/restore/'.$article->article_id) }}" method="POST" style="display: inline;">
                  <input name="_method" type="hidden" value="PUT">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <button type="submit" class="btn btn-xs btn-primary">恢复</button>
                </form>
              </td>
            </tr>
            @endif
            @endforeach
          </table>

        </div>
      </div>
    </div>
  </div>
</div>
@endsection
