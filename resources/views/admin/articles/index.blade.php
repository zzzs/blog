@extends('_layouts.adminbase')

@section('content')
<div class="container">
  <div class="row">
      <div class="panel panel-default">
        <div class="panel-heading">
          <form class="form-inline" action="/admin/articles" method="GET">文章管理
            <div class="form-group">
              <label class="sr-only">分类</label>
              <select class="form-control" name="cate">
                <option value="" selected="selected">全部</option>
                @foreach ($cates as $cate)
                  @if (isset($request['cate']) && $cate->tag_id == $request['cate'])
                  <option value="{{ $cate->tag_id }}" selected="selected">{{ $cate->name }}</option>
                  @else
                  <option value="{{ $cate->tag_id }}">{{ $cate->name }}</option>
                  @endif
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label class="sr-only">评论</label>
              <select class="form-control" name="comstatus">
                <option value="" selected="selected">全部</option>
                <option value="0">待处理</option>
                <option value="1">通过</option>
                <option value="2">拒绝</option>
              </select>
            </div>
            <div class="form-group">
              <label class="sr-only">标题</label>
              <input type="text" name="title" value="{{ $request['title'] or '' }}" class="form-control" placeholder="标题">
            </div>
            <button type="submit" class="btn btn-default">Go</button>
            <a href="{{ URL('admin/articles/create') }}" class="btn btn-xs btn-primary add_but">新增</a>
          </form>
        </div>

        <div class="panel-body">
          <table class="table table-striped table-hover" style="table-layout:fixed;">
            <tr class="row">
              <th class="col-lg-1">文章ID</th>
              <th class="col-lg-5">标题</th>
              <th class="col-lg-2">分类</th>
              <th class="col-lg-1">推荐</th>
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
                <a target="_blank" class="text-primary" href="/articles/{{ $article->article_id }}">{{ $article->title }}</a>
              </td>
              <td class="col-lg-2">
                {{ $article->Tag->name }}
              </td>
              <td  class="col-lg-1">
                <a href="{{ URL('admin/articles/recommends/'.$article->article_id) }}" class="btn btn-xs btn-default">{{ count($article->recommends) }}</a>
              </td>
              <td class="col-lg-1">
                @if (count($article->comments->toArray()) > 0)
                <a href="{{ URL('admin/articles/comments/'.$article->article_id) }}" class="btn btn-xs {{ $article->hasNewComment ? 'btn-danger' : 'btn-info' }}">查看</a>
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
              <td class="col-lg-2">
                {{ $article->Tag->name }}
              </td>
              <td  class="col-lg-1">
                <a href="{{ URL('admin/articles/recommends/'.$article->article_id) }}" class="btn btn-xs btn-default">{{ count($article->recommends) }}</a>
              </td>
              <td class="col-lg-1">
                @if ( $article->article_id > 0)
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
<center>
  {!! $articles->render() !!}
</center>
<script>
var comstatus = "{{ $request['comstatus'] or '' }}";
if (comstatus.length !== 0) {
  $("form select[name='comstatus']").find("option[value="+comstatus+"]").attr('selected','selected');
}
</script>
@endsection
