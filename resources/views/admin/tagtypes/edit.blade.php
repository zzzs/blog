@extends('_layouts.adminbase')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default">
        <div class="panel-heading">编辑标签类型</div>

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

          <form action="{{ URL('admin/tagtypes/'.$tagtype->id) }}" method="POST" class="form-horizontal">
            <input name="_method" type="hidden" value="PUT">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">
              <label class="col-sm-2 control-label">类型</label>
              <div class="col-sm-10">
                <input type="text" name="name" class="form-control" placeholder="类型" required="required" value="{{ $tagtype->name }}">
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">备注</label>
              <div class="col-sm-10">
                <textarea name="remark" class="form-control" rows="3" required="required">{{ $tagtype->remark }}</textarea>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-default">编辑标签类型</button>
              </div>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>
</div>
@endsection
