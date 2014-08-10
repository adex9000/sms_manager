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
                    <h3 class="panel-title">New Staff</h3>
                </div>
                <div class="panel-body">

                    <div class="row">
                        <div class="col-lg-8">

                            <form action="{{ URL::route('new_staff_member') }}" role="form" method="post">
                                {{ Form::token() }}
                                <div class="form-group">
                                    <label for="first_name" class="sr-only">First Name</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" placeholder="First Name:">
                                    {{ $errors->first('first_name', '<span class="help-block alert alert-danger">:message</span>') }}
                                </div>
                                <div class="form-group">
                                    <label for="surname" class="sr-only">Surname</label>
                                    <input type="text" class="form-control" id="surname" name="surname" placeholder="Surname:">
                                    {{ $errors->first('surname', '<span class="help-block alert alert-danger">:message</span>') }}
                                </div>
                                <div class="form-group">
                                    <label for="staffno" class="sr-only">Staff No.</label>
                                    <input type="text" class="form-control" id="staffno" name="staffno" placeholder="Staff No (optional):">
                                    {{ $errors->first('staffno', '<span class="help-block alert alert-danger">:message</span>') }}
                                </div>
                                <div class="form-group">
                                    <label for="gsm_no" class="sr-only">GSM No.</label>
                                    <input type="text" class="form-control" id="gsm_no" name="gsm_no" placeholder="GSM No:">
                                    {{ $errors->first('gsm_no', '<span class="help-block alert alert-danger">:message</span>') }}
                                </div>

                                @if($staff_types & count($staff_types) > 0)
                                    @foreach($staff_types as $key => $value)
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="staff_types[]" value="{{ $key }}"> {{ $value }} Member
                                            </label>
                                        </div>
                                    @endforeach
                                    {{ $errors->first('staff_types', '<span class="help-block alert alert-danger">:message</span>') }}
                                @endif
                                <button type="submit" class="btn btn-primary">Add Staff</button>
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
        </div>

    </div>

</div>

@stop