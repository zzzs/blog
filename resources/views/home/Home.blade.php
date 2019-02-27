@extends('_layouts.homebase')

@section('content')
	<div id="content" class="container">
		@foreach ($article_lists as $article)
		<div class="con_item">
			<div class="title">
				<a href="{{ URL('articles/'.$article['article_id']) }}">
					<h2>{{ $article['title'] }}</h2>
				</a>
			</div>
			<div class="date">
				<p>{{ date('Y-m-d',$article['created_at']) }}</p>
			</div>
		</div>
		@endforeach
	</div>
	<div id="content-page">
		{!! $article_lists->render() !!}
	</div>
@endsection
