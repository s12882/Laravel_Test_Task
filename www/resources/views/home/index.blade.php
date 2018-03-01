@extends('layouts.layout')
@section('title','Home page')
@section('page_styles')	
@stop
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="portlet light bordered">
            <div class="portlet-title">
                <div class="caption">
                    <i class="icon-puzzle"></i>Pages</div>
                <div class="tools">
                    <a href="javascript:;" class="collapse" data-original-title="Zwiń/rozwiń" title=""> </a>
                </div>
            </div>
            <div class="portlet-body">
                <div class='tiles'>

                    <a href='{{route('news.index')}}'>
                        <div class="tile bg-green-meadow">
                            <div class="tile-body">
                                <i class="fa fa-list-alt"></i>
                            </div>
                            <div class="tile-object">
                                <div class="name"> News </div>
                            </div>
                        </div>                    
                    </a>

                     <a href='{{route('resp.index')}}'>
                        <div class="tile bg-blue">
                            <div class="tile-body">
                                <i class="fa fa-book"></i>
                            </div>
                            <div class="tile-object">
                                <div class="name"> Responses </div>
                            </div>
                        </div>                    
                    </a>
                  
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('plugin_js')
@stop
@section('page_js')
@stop 
