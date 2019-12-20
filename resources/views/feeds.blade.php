<!DOCTYPE html>
<html>
<head>
	<title>Feeds</title>
	<link rel="stylesheet" type="text/css" href="{{asset('css/style.css')}}">
</head>
<body>
	<a href="/importData" id="importButton">Import Data</a>
	<div id = "filterButtonContainer">
		<span>Select from : </span>
		<br>
		@foreach($sources as $source)
		<br>
		<div class="filterButton" onclick="filter('{{$source}}', this)">
				{{$source}}
		</div>
		@endforeach
		<br>
		<span>*Red background means selected</span>
	</div>
	@foreach($datas as $data)
	<a class="feedsContainer {{$data->source}}" href="{{$data->newsLink}}" target="_blank">
		<div class="feeds">
			<div class="left">
				<img class="image" src="{{$data->imageLink}}">
			</div>
			<div class="right">
				<span class="title">{{$data->title}}</span>
				<br>
				<span class="pubdate">Released on : {{$data->pubdate}}</span>
				<br>
				<span class="source">Source : {{$data->source}}</span>
				<br>
			</div>
		</div>
	</a>
	@endforeach
	<script type="text/javascript" src="{{asset('js/filter.js')}}"></script>
</body>
</html>