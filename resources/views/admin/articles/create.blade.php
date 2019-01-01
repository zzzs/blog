@extends('_layouts.adminbase')

@section('content')
<div class="container">
  <div class="row">
    <div class="panel panel-default">
      <div class="panel-heading">新增 文章</div>

      <div class="panel-body">

        @if (count($errors) > 0)
        <div class="alert alert-danger">
          <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
        @endif

        <form action="{{ URL('admin/articles') }}" method="POST" class="form-horizontal">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <div class="form-group">
            <label class="col-sm-2 control-label">标题</label>
            <div class="col-sm-10">
              <input type="text" name="title" class="form-control" required="required">
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">分类</label>
            <div class="col-sm-10">
              <select class="form-control" name="cate">
                @foreach ($cates as $cate)
                <option value="{{ $cate->tag_id }}">{{ $cate->name }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label">内容</label>
            <div class="col-sm-10">
              <textarea name="body" rows="10" class="form-control" required="required"></textarea>
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <button type="submit" class="btn btn-default">新增 文章</button>
            </div>
          </div>
        </form>

      </div>
    </div>
  </div>
</div>
@endsection
