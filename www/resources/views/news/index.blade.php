@extends('layouts.layout')
@section('title','News')
@section('page-styles')
<link href="{{ asset('assets/global/plugins/bootstrap-sweetalert/sweetalert.css')}}" rel="stylesheet">
<link href="{{ asset('assets/global/plugins/datatables-buttons/css/buttons.dataTables.min.css')}}" rel="stylesheet"/>
<link href="{{asset('assets/global/plugins/datatables-responsive/responsive.dataTables.min.css')}}" rel="stylesheet" id="style_components" type="text/css" />
<link rel="stylesheet" type="text/css" href="{{asset('assets/global/plugins/bootstrap-select/css/bootstrap-select.min.css')}}"/>
@stop
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption font-grey-mint">
                    <i class="fa fa-news fa-2x font-grey-mint"></i>
                    <span class="caption-subject uppercase bold">News page</span>
                </div>
            </div>
            <div class="portlet-body">
                <div class="row no-gutters">                        
                        <div class="col-lg-3 col-md-6 no-gutters">
                                <div class="form-group">
                                    <div class="input-group date-picker input-daterange" data-date-format="yyyy-mm-dd">
                                        <input type="text" class="form-control filter" name="date_from">
                                        <span class="input-group-addon"> to </span>
                                        <input type="text" class="form-control filter" name="date_to"></div>
                                    <span class="help-block"> Dates </span>
                                </div>
                            </div>
                        </div>
                @can('create news')
                <div class="table-toolbar">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="btn-group">
                                <a href="{{route('news.create')}}" class="btn grey-mint btn-outline">
                                    Add
                                    <i class="fa fa-plus-circle"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endcan
                </div>
                <table class="table table-bordered table-striped table-responsive" id="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Description</th>                                              
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@stop
@section('plugin-js')
<script src="{{ asset('assets/global/plugins/datatables/datatables.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}" type="text/javascript"></script>
<script src="{{ asset('assets/global/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/global/plugins/bootstrap-select/js/bootstrap-select.min.js')}}" type="text/javascript"></script>
<script>
        (function ($) {
            $.fn.datepicker.dates['pl'] = {
                days: ["sunday", "monday", "tuesday", "wednesday", "thursday", "friday", "suttarday"],
                daysShort: ["sun.", "mon.", "tue.", "wed.", "thu.", "fri.", "sut."],
                daysMin: ["sun.", "mon.", "tue.", "wed.", "thu.", "fri.", "sut."],
                months: ["styczeń", "luty", "marzec", "kwiecień", "maj", "czerwiec", "lipiec", "sierpień", "wrzesień", "październik", "listopad", "grudzień"],
                monthsShort: ["sty.", "lut.", "mar.", "kwi.", "maj", "cze.", "lip.", "sie.", "wrz.", "paź.", "lis.", "gru."],
                today: "dzisiaj",
                weekStart: 1,
                clear: "wyczyść",
                format: "dd.mm.yyyy"
            };
        }(jQuery));
    </script>
@stop
@section('page-js')
@include('news.partials.index-page-scripts')
@stop
