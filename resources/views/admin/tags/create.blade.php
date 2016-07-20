@extends('admin.app')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default">
        <div class="panel-heading">新增标签</div>

        <div class="panel-body">

          @if (count($errors) > 0)
            <div class="alert alert-danger">
              <strong>Whoops!</strong> There were some problems with your input.<br><br>
              <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <form action="{{ URL('admin/tags') }}" method="POST" class="form-horizontal">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">
              <label class="col-sm-2 control-label">类型</label>
              <div class="col-sm-10">
                <select class="form-control" name="type">
                  @foreach ($tagtypes as $tagtype)
                    <option value="{{ $tagtype->id }}">{{ $tagtype->name }}</option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">内容</label>
              <div class="col-sm-10">
                <textarea name="name" class="form-control" rows="3" required="required"></textarea>
              </div>
            </div>
            <div class="form-group">
              <label class="col-sm-2 control-label">附加</label>
              <div class="col-sm-10">
                <textarea name="more" class="form-control" rows="2"></textarea>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-default">新增标签</button>
              </div>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>
</div>
@endsection
