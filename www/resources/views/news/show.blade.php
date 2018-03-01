@extends('layouts.layout') @section('page-styles')
<link href="{{asset('assets/pages/css/task.show.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/global/plugins/bootstrap-sweetalert/sweetalert.css')}}" rel="stylesheet" type="text/css" />
<link href="{{ asset('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css')}}" rel="stylesheet"> @stop @section('content')
<h3 class="page-title">Details</h3>
<div class="row">
	<div class='col-md-12 col-lg-6'>
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-info-circle font-grey-mint"></i>
					<span class="caption-subject font-grey-mint bold uppercase">{{$news->name}}</span>
				</div>
			</div>
			<div class="portlet-body form-horizontal">
				<div class="form-body">
					<div class="form-group">
						<label class="control-label col-sm-2">Descriptions:</label>
						<div class="col-sm-10">
							<p class="form-control-static">{{$news->description}}</p>
						</div>
					</div>			
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-12 col-lg-6">
		<div class="panel panel-primary">
			<div class="panel-heading" id="accordion">
				<span class="glyphicon glyphicon-comment"></span> Comments
			</div>
			<div class="panel" id="collapseOne">
				<div class="panel-body">
					<ul class="chat">
					</ul>
				</div>				
			</div>
		</div>
	</div>
</div>
		@if(isset($news) && count($news->images)> 0)
		<div class="row">
		<div class='col-sm-12'>
			<div class="portlet light bordered">
				<div class="portlet-title">
					<div class="caption">
						<i class="fa fa-image font-grey-mint"></i>
						<span class="caption-subject font-grey-mint bold uppercase">Images</span>
					</div>
				</div>
				<div class="portlet-body">
					<div class='row'>
						@foreach($news->images as $index=>$image)
						<div class="col-sm-3 col-xs-6">
							<img src='{{asset($image->webPath())}}' class='img-responsive thumbnail'>
							<a class="image-download-button btn red btn-xs" data-toggle="tooltip" data-title="Pobierz plik" href="{{route('news.download_image',['id' => $image->id])}}"
							 type="button" type="button">
								<span class="red">
									<i class="fa fa-download"></i>
								</span>
							</a>
						</div>
						@if(($index + 1) % 4 == 0)
						<div class='clearfix visible-lg visible-md visible-sm'></div>
						@endif @endforeach
					</div>
				</div>
			</div>
		</div>
	</div>
	@endif
	<div class="row">
		<div class='col-sm-12'>
			<div class="portlet light bordered">				
			<div class="row">			
			</div>
		</div>
	</div>
	</div>
</div>
	@stop @section('page-js')
	<script src="{{ asset('assets/global/scripts/jquery.tmpl.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js')}}" type="text/javascript"></script>
	<script src="{{ asset('assets/global/plugins/datatables/datatables.min.js')}}" type="text/javascript"></script>
	<script src="{{ asset('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js')}}" type="text/javascript"></script>
	<script src="{{ asset('assets/global/plugins/datatables-responsive/dataTables.responsive.min.js')}}" type="text/javascript"></script>
	@include('news.partials.show-page-scripts') 
	@stop