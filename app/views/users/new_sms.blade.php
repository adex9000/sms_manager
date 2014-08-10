@extends('layouts.master')

@section('content')

@include('partials._nav')

<div class="container">
    <h3 class="sm-heading text-uppercase">SMS</h3>
    @include('flash::message')
    <div class="row">

        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Compose New SMS</h3>
                </div>
                @include('partials._new_sms')
            </div>
        </div>

    </div>

</div>

@stop

@section('scripts')
<script src="{{ asset('assets/js/main.js') }}"></script>
@stop