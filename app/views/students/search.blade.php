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
                    <h3 class="panel-title">Students: Search</h3>
                </div>
                <div class="panel-body">

                    <div class="row">
                        <div class="col-lg-12 sm-form">
                            {{ $errors->first('student_search', '<span class="help-block alert alert-danger">:message</span>') }}
                            <form action="{{ URL::route('student_search') }}" class="form-inline" role="form" method="post">
                                {{ Form::token() }}
                                <div class="form-group">
                                    <label for="search" class="sr-only">Matric No.</label>
                                    <input type="text" class="form-control" id="search" name="student_search" placeholder="Matric No, First Name or Surname">
                                </div>
                                <button type="submit" class="btn btn-default">
                                    <span class="glyphicon glyphicon-search"></span>
                                    Search
                                </button>
                            </form>
                        </div>

                        <div class="col-lg-12">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Matric Number</th>
                                    <th>First Name</th>
                                    <th>Surname</th>
                                    <th>Phone No</th>
                                    <th>Parent No</th>
                                    @if($results && count($results) > 1)
                                    <th class="text-center" style="font-weight: normal; text-decoration: underline;">
                                        <form action="{{ URL::route('send_sms_message') }}" role="form" method="post">
                                            {{ Form::token() }}
                                            {{ Form::hidden('sms_all',Utilities::simpleEncode(serialize($results))) }}
                                            <button type="submit" class="btn-link">Send SMS to all Students</button>
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
                                    @foreach($results as $student)
                                        <tr>
                                            <td>{{ $serial_number++ }}</td>
                                            <td class="text-uppercase">{{ $student->regno }}</td>
                                            <td class="text-uppercase">{{ $student->firstname }}</td>
                                            <td class="text-uppercase">{{ $student->surname }}</td>
                                            <td>{{ Utilities::formatGsmNumber($student->telno) }}</td>
                                            <td>{{ Utilities::formatGsmNumber($student->nokgsm) }}</td>
                                            <td>
                                                <form action="{{ URL::route('send_sms_message') }}" role="form" method="post">
                                                    {{ Form::token() }}
                                                    @if(! empty($student->telno))
                                                    {{ Form::hidden('sms_single',Utilities::simpleEncode(serialize(Utilities::formatGsmNumber($student->telno)))) }}
                                                    <input type="submit" name="single" class="btn btn-sm btn-primary" value="Send SMS">
                                                    @endif
                                                    @if(! empty($student->nokgsm))
                                                    {{ Form::hidden('sms_parents',Utilities::simpleEncode(serialize(Utilities::formatGsmNumber($student->nokgsm)))) }}
                                                    <input type="submit" name="parents" class="btn btn-sm btn-info" value="Send SMS to Parent">
                                                    @endif
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="8">No record(s) to display! Search above to see results.</td>
                                    </tr>
                                @endif

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>

</div>

@stop