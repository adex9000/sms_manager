@extends('layouts.master')

@section('content')

@include('partials._nav')

<div class="container">
    <h3 class="sm-heading text-uppercase">Phone Book</h3>
    @include('flash::message')
    <div class="row">

        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Staff: Search</h3>
                </div>
                <div class="panel-body">

                    <div class="row">

                        <div class="col-lg-8 col-md-10">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Staff Number</th>
                                    <th>First Name</th>
                                    <th>Surname</th>
                                    <th>Phone No</th>
                                    @if($results && count($results) > 1)
                                    <th class="text-center" style="font-weight: normal; text-decoration: underline;">
                                        <form action="{{ URL::route('send_sms_message') }}" role="form" method="post">
                                            {{ Form::token() }}
                                            {{ Form::hidden('sms_all',Utilities::simpleEncode(serialize($results))) }}
                                            <button type="submit" class="btn-link">Send SMS to all Staff</button>
                                        <!-- Enhance experience with modal confirmation box -->
                                        </form>
                                    </th>
                                    @else
                                    <th class="text-center"">Action</th>
                                    @endif
                                </tr>
                                </thead>
                                <tbody>
                                    @if($results && count($results) > 0)
                                        @foreach($results as $staff)
                                            <tr>
                                                <td>{{ $serial_number++ }}</td>
                                                <td class="text-uppercase">{{ $staff->staffno }}</td>
                                                <td class="text-uppercase">{{ $staff->firstname }}</td>
                                                <td class="text-uppercase">{{ $staff->lastname }}</td>
                                                <td>{{ Utilities::formatGsmNumber($staff->gsmno) }}</td>
                                                <td>
                                                    <form action="{{ URL::route('send_sms_message') }}" role="form" method="post">
                                                        {{ Form::token() }}
                                                        {{ Form::hidden('sms_single',Utilities::simpleEncode(serialize(Utilities::formatGsmNumber($staff->gsmno)))) }}
                                                        <button type="submit" name="single" class="btn btn-sm btn-primary">Send SMS</button>
                                                        <a href="{{ URL::route('edit_staff', $staff->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                                    </form>

                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                    <tr>
                                        <td colspan="6">No record(s) to display! Search above to see results.</td>
                                    </tr>
                                    @endif
                                </tbody>
                                </form>
                            </table>
                        </div>

                        <div class="col-lg-4 col-md-2">

                            <form action="{{ URL::route('staff_search') }}" role="form" method="post">
                                {{ Form::token() }}
                                <div class="form-group">
                                    <label for="search" class="sr-only">Staff No.</label>
                                    <input type="text" class="form-control" id="search" name="staff_search" placeholder="Staff No, First Name or Surname">
                                    {{ $errors->first('staff_search', '<span class="help-block alert alert-danger">:message</span>') }}
                                </div>
                                <button type="submit" class="btn btn-default">
                                    <span class="glyphicon glyphicon-search"></span>
                                    Search
                                </button>
                            </form>

                        </div>

                    </div>

                </div>
            </div>
        </div>

    </div>

</div>

@stop