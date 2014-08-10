@extends('layouts.master')

@section('content')

@include('partials._nav')

<div class="container">
    <h3 class="sm-heading text-uppercase">Dashboard</h3>
    @include('flash::message')
    <div class="row">

        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">SMS Capacity</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="dashboard-labels text-center">
                                <h1><span class="label label-primary">{{ $sms_balance }}</span></h1>
                                <p>SMS Units Remaining</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="dashboard-labels text-center">
                                <!-- Okay, Warning, Danger -->
                                <h1>{{ $sms_balance_status }}</h1>
                                <p>SMS Health Status</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Recent SMS Messages</h3>
                </div>
                <div class="panel-body">
                    <table class="table table-bordered">
                        <thead>
                        </thead>
                        <tbody>

                        @if($sent_sms && count($sent_sms) > 0)
                            @foreach($sent_sms as $sms)
                                <tr>
                                    <td width="5%">{{ $serial_number++ }}</td>
                                    <td>{{ $sms->messagebody }}</td>
                                    <td width="12%">{{ $sms->created_at->diffForHumans() }}</td>
                                    <td width="15%"><a href="{{ URL::route('edit_sms',$sms->id) }}" class="btn btn-sm btn-primary btn-block">Edit &amp; Re-send</a></td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="4">You have not sent any SMS!</td>
                            </tr>
                        @endif

                        </tbody>
                    </table>

                </div>
            </div>
        </div>

    </div>

</div>

@stop