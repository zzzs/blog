@extends('_layouts.adminbase')

@section('content')
<div class="container">
  <div class="row">
    <div class="col-md-10 col-md-offset-1">
      <div class="panel panel-default">
        <div class="panel-heading">编辑标签</div>

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

          <form action="{{ URL('admin/tags/'.$tag->tag_id) }}" method="POST" class="form-horizontal">
            <input name="_method" type="hidden" value="PUT">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="form-group">
              <label class="col-sm-2 control-label">类型</label>
              <div class="col-sm-10">
               <select class="form-control" name="type">
                @foreach ($tagtypes as $tagtype)
                  @if ($tagtype->id == $tag->type)
                  <option value="{{ $tagtype->id }}" selected="selected">{{ $tagtype->name }}</option>
                  @else
                  <option value="{{ $tagtype->id }}">{{ $tagtype->name }}</option>
                  @endif
                @endforeach
              </select>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label">内容</label>
              <div class="col-sm-10">
                <textarea name="name" class="form-control" rows="3" required="required">{{ $tag->name }}</textarea>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label">附加</label>
              <div class="col-sm-10">
                <textarea name="more" class="form-control" rows="2">{{ $tag->extra }}</textarea>
              </div>
            </div>

            <div class="form-group">
              <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-default">编辑标签</button>
              </div>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>
</div>
@endsection
