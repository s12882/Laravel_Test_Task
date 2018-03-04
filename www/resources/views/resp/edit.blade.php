@extends('layouts.layout') @section('page-styles')
<link href="{{ asset('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css')}}" rel="stylesheet">
<link href="{{ asset('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker.css')}}" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{asset('assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css')}}">
<link href="{{ asset('assets/global/plugins/bootstrap-sweetalert/sweetalert.css')}}" rel="stylesheet"> @stop @section('content')
<div class="row">
	<div class="col-md-12">
		<div class="portlet light bordered">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-resp font-grey-mint"></i>
					<span class="caption-subject font-grey-mint bold uppercase">{{$pageTitle}}</span>
				</div>
			</div>
			<div class="portlet-body form">
				{!! Form::model($resp,array('url' => $postAction, 'method'=>$actionMethod,'class'=>'form-horizontal', 'id' => 'resp_form',
				'files' => true)) !!} {!! Form::hidden('id',null) !!} {!! Form::hidden('assignedUsers',null, array('id' => 'assignedUsers'))
				!!}
				<div class="form-body">
					<div class="form-group">
						<label class="col-md-2 control-label">
							Name
							<span class="required" aria-required="true"> * </span>
						</label>
						<div class="col-lg-9 col-md-10">
							{!! Form::text('name', null, ['class' => 'form-control', 'autocomplete' =>'off', 'spellcheck'=>'false']) !!}
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-2 control-label">
							Content:
							<span class="required" aria-required="true"> * </span>
						</label>
						<div class="col-lg-9 col-md-10">
							{!! Form::textarea('description', null, ['id' => 'description', 'rows' => '5', 'class' => 'form-control', 'autocomplete'=>'off',
							'spellcheck'=>'false']) !!}
						</div>
					</div>
					@if(!preg_match( '/create/', Route::currentRouteName()))
					<div class="form-group">
						<label class="col-md-2 control-label">
							Status:
							<span class="required" aria-required="true"> * </span>
						</label>
						<div class="col-lg-9 col-md-10">
							{!! Form::select('status', $status, null, ['class' => 'form-control selectpicker','data-none-selected-text' => "Nie wybrano
							obiektu", 'data-live-search'=>'true', 'autocomplete' =>'off', 'spellcheck'=>'false']) !!}
						</div>
					</div>
					@endif					
						<div class="form-actions">
							<div class="row">
								<div class="col-md-offset-3 col-lg-5 col-md-7">
									{!! Form::submit('Confirm', ['class'=>'btn grey-mint grey-mint-stripe btn-outline']) !!}
									<a class="btn red red-stripe btn-outline" href="{{route('resp.index')}}">Cancel</a>
									{!! Form::close() !!}
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@stop 
@section('plugin-js')
<script src="{{asset('assets/global/plugins/jquery-validation/js/jquery.validate.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/global/plugins/jquery-validation/js/additional-methods.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/global/plugins/jquery-validation/js/localization/messages_pl.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/datatables/datatables.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js')}}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}" type="text/javascript"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/locales/bootstrap-datepicker.pl.min.js"
 charset="UTF-8"></script>
<script src="{{ asset('assets/global/plugins/datatables-responsive/dataTables.responsive.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js')}}" type="text/javascript"></script> @stop 
@section('page-js') 
@include('resp.partials.edit-page-scripts') 
{{--  @include('resp.partials.items-section-scripts')   --}}
@stop