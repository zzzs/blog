@extends('_layouts.adminbase')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default">
        <div class="panel-heading">标签管理
        <a href="{{ URL('admin/tags/create') }}" class="btn btn-xs btn-primary">新增</a>
      </div>

        <div class="panel-body">

        <table class="table table-striped">
          <tr class="row">
            <th class="col-lg-2">标签ID</th>
            <th class="col-lg-6">内容</th>
            <th class="col-lg-2">类型</th>
            <th class="col-lg-1">编辑</th>
            <th class="col-lg-1">删除</th>
          </tr>
          @foreach ($tags as $tag)
            <tr class="row">
              <td class="col-lg-2">
                {{ $tag->tag_id }}
              </td>
              <td class="col-lg-6">
                {{ $tag->name }}
              </td>
              <td class="col-lg-2">
                {{ $tag->tagtype->name }}
              </td>
              <td class="col-lg-1">
                <a href="{{ URL('admin/tags/'.$tag->tag_id.'/edit') }}" class="btn btn-xs btn-success">编辑</a>
              </td>
              <td class="col-lg-1">
                <form action="{{ URL('admin/tags/'.$tag->tag_id) }}" method="POST" style="display: inline;">
                  <input name="_method" type="hidden" value="DELETE">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <button type="submit" class="btn btn-xs btn-danger">删除</button>
                </form>
              </td>
            </tr>
          @endforeach
        </table>


        </div>
      </div>
    </div>
  </div>
</div>
@endsection
