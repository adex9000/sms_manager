@extends('layouts.master')

@section('content')

@include('partials._nav')

<div class="container">
    <h3 class="sm-heading text-uppercase">Phone Book</h3>
    @include('flash::message')
    <div class="row">

        <div class="col-lg-12">

            @if(!$staff)
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Oops!</h3>
                </div>
                <div class="panel-body">
                    <p>You have not added any staff. Please do so before editing staff records! Click <a href="{{ URL::route('new_staff') }}">here</a> to add a new staff.</p>
                </div>
            </div>
            @else

            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Edit Staff: {{ Str::upper($staff['firstname'] . ' ' . $staff['lastname']) }}</h3>
                </div>
                <div class="panel-body">

                    <div class="row">
                        <div class="col-lg-8">

                            <form action="{{ URL::route('edit_staff_member') }}" role="form" method="post">
                                {{ Form::token() }}
                                <div class="form-group">
                                    <label for="first_name" class="sr-only">First Name</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" value="{{ $staff['firstname'] }}" placeholder="First Name:">
                                    {{ $errors->first('first_name', '<span class="help-block alert alert-danger">:message</span>') }}
                                </div>
                                <div class="form-group">
                                    <label for="surname" class="sr-only">Surname</label>
                                    <input type="text" class="form-control" id="surname" name="surname" value="{{ $staff['lastname'] }}" placeholder="Surname:">
                                    {{ $errors->first('surname', '<span class="help-block alert alert-danger">:message</span>') }}
                                </div>
                                <div class="form-group">
                                    <label for="gsm_no" class="sr-only">GSM No.</label>
                                    <input type="text" class="form-control" id="gsm_no" name="gsm_no" value="{{ $staff['gsmno'] }}"  placeholder="GSM No:">
                                    {{ $errors->first('gsm_no', '<span class="help-block alert alert-danger">:message</span>') }}
                                </div>

                                @if($staff_types & count($staff_types) > 0)
                                    @foreach($staff_types as $key => $value)
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="staff_types[]" value="{{ $key }}" {{ Utilities::checkedStatus($key, $staff['staff_types']) }}> {{ $value }} Member
                                            </label>
                                        </div>
                                    @endforeach
                                    {{ $errors->first('staff_types', '<span class="help-block alert alert-danger">:message</span>') }}
                                @endif
                                {{ Form::hidden('staff_id',$staff['id']) }}
                                <button type="submit" name="update" class="btn btn-primary pull-right">Update</button>
                                <button type="submit" name="delete" class="btn btn-danger pull-left">Delete Staff</button>
                            </form>

                        </div>
                        <div class="col-lg-4 visible-lg">
                            <dl>
                                <dt>First Name</dt>
                                <dd>First Name of New Staff</dd>

                                <dt>Surname</dt>
                                <dd>Surname of New Staff</dd>

                                <dt>Staff No.</dt>
                                <dd>Optional Staff Number for new Staff</dd>

                                <dt>GSM No.</dt>
                                <dd>GSM Number for new Staff</dd>
                            </dl>
                        </div>
                    </div>

                </div>
            </div>

            @endif
        </div>

    </div>

</div>

@stop