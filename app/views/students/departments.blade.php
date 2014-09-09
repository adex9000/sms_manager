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
                    <h3 class="panel-title">Students: Departments</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12 sm-form">
                        <div class="row">
                            <div class="col-lg-6">
                                <form action="{{ URL::route('search_departments') }}" class="form-inline" role="form" method="get">
                                    <div class="form-group">
                                        <label for="search">Department</label>
                                        {{ Form::select('search',$departments,$search,['class'=>'form-control','id'=>'search']) }}
                                        <label for="level">Level</label>
                                        {{ Form::select('level',$levels,$level,['class'=>'form-control','id'=>'level']) }}
                                    </div>
                                    <button type="submit" class="btn btn-default">
                                        <span class="glyphicon glyphicon-search"></span>
                                        Search
                                    </button>
                                </form>
                            </div>
                                @if($results)
                                <div class="col-lg-6">
                                        <form action="{{ URL::route('csv') }}" style="display: inline-block;" role="form" method="post">
                                            {{ Form::token() }}
                                            {{ Form::hidden('csv',Utilities::simpleEncode(serialize($allResults->toArray()))) }}
                                            {{ Form::hidden('source','department') }}
                                            <button type="submit" class="btn btn-info">
                                            <span class="glyphicon glyphicon-cloud-download"></span>
                                            CSV
                                            </button>
                                            <!-- Enhance experience with modal confirmation box -->
                                        </form>
                                        <form action="{{ URL::route('csv') }}" style="display: inline-block;" role="form" method="post">
                                            {{ Form::token() }}
                                            {{ Form::hidden('xls',Utilities::simpleEncode(serialize($allResults->toArray()))) }}
                                            {{ Form::hidden('source','department') }}
                                            <button type="submit" class="btn btn-danger">
                                            <span class="glyphicon glyphicon-cloud-download"></span>
                                            MS Excel
                                            </button>
                                            <!-- Enhance experience with modal confirmation box -->
                                        </form>
                                        <form action="{{ URL::route('csv') }}" style="display: inline-block;" role="form" method="post">
                                            {{ Form::token() }}
                                            {{ Form::hidden('xlsx',Utilities::simpleEncode(serialize($allResults->toArray()))) }}
                                            {{ Form::hidden('source','department') }}
                                            <button type="submit" class="btn btn-success">
                                            <span class="glyphicon glyphicon-cloud-download"></span>
                                            MS Excel 2007+
                                            </button>
                                            <!-- Enhance experience with modal confirmation box -->
                                        </form>
                                </div>
                                @endif
                            </div>
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
                                    <th>Department</th>
                                    <th>Level</th>
                                    @if($results && count($results) > 1)
                                        <th class="text-center" style="font-weight: normal; text-decoration: underline;">
                                            <form action="{{ URL::route('send_sms_message') }}" role="form" method="post">
                                                {{ Form::token() }}
                                                {{ Form::hidden('sms_all',Utilities::simpleEncode(serialize($allResults->toArray()))) }}
                                                <button type="submit" class="btn-link">Send SMS to all</button>
                                                <!-- Enhance experience with modal confirmation box -->
                                            </form>
                                        </th>
                                    @else
                                        <th class="text-center">Action</th>
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
                                                <td>{{ Utilities::expandDepartment($student->deptid) }}</td>
                                                <td>{{ Utilities::expandLevel($student->levelid) }}</td>
                                                <td>
                                                    <form action="{{ URL::route('send_sms_message') }}" role="form" method="post">
                                                        {{ Form::token() }}
                                                    @if(! empty($student->telno))
                                                                {{ Form::hidden('sms_single',Utilities::simpleEncode(serialize(Utilities::formatGsmNumber($student->telno)))) }}
                                                                <p><input type="submit" name="single" class="btn btn-sm btn-primary" value="Send SMS"></p>
                                                        @endif
                                                        @if(! empty($student->nokgsm))
                                                                {{ Form::hidden('sms_parents',Utilities::simpleEncode(serialize(Utilities::formatGsmNumber($student->nokgsm)))) }}
                                                                <input type="submit" name="parents" class="btn btn-sm btn-info" value="Send SMS to Parent">
                                                    @endif
                                                   </form>
                                                </td>
                                            </tr>
                                        @endforeach

                                        @if($results->getTotal() > 30)
                                            <tr>
                                                <td colspan="9">{{ $results->appends(['search' => $search, 'level' => $level])->links()  }}</td>
                                            </tr>
                                        @endif

                                        @else
                                        <tr>
                                            <td colspan="9">No record(s) to display! Search above to see results.</td>
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