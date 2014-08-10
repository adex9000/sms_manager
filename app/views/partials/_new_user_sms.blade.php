<div class="panel-body">

    <div class="row">
        <div class="col-lg-8">

            <form action="{{ URL::route('send_sms') }}" role="form" method="post">
                {{ Form::token() }}
                <div class="form-group">
                    <label for="sender_id" class="sr-only">Sender Label</label>
                    <input type="text" class="form-control" id="sender_id" name="sender_id" value="BinghamICT" placeholder="Sender Label">
                    {{ $errors->first('sender_id', '<span class="help-block alert alert-danger">:message</span>') }}
                </div>
                <div class="form-group">
                    <label for="destination_nos" class="sr-only">Destination GSM Nos.</label>
                    <textarea class="form-control" id="destination_nos" name="destination_nos" rows="3" placeholder="Destination GSM Nos.">{{ $gsm_numbers }}</textarea>
                    {{ $errors->first('destination_nos', '<span class="help-block alert alert-danger">:message</span>') }}
                </div>
                <div class="form-group">
                    <label for="sms_message" class="sr-only">Message</label>
                    <textarea class="form-control" id="sms_message" name="sms_message" rows="10" placeholder="Message">{{ Input::old('sms_message') }}</textarea>
                </div>
                <p class="text-right">Message Count: <span id="message_count" class="label label-lg label-primary message-label">0</span>/<span id="sms_count" class="label label-lg label-primary message-label">1</span></p>
                {{ $errors->first('sms_message', '<span class="help-block alert alert-danger">:message</span>') }}
                <div class="checkbox">
                    <label>
                        <input type="checkbox" checked="checked" name="long_sms"> Send as long SMS?
                    </label>
                    <span class="help-block">Deliver more that 160 characters as a single SMS</span>
                </div>
                <button type="submit" class="btn btn-primary pull-right">Send SMS</button>
            </form>

        </div>
        <div class="col-lg-4 visible-lg">
            <dl>
                <dt>Sender Label</dt>
                <dd>The title of the SMS sender. E.G. BinghamICT</dd>

                <dt>Destination GSM Nos.</dt>
                <dd>The destination phone numbers formatted as follows: 2348011112222. To send to many users, simply enter a comma seperated list of GSM nos.</dd>

                <dt>Message</dt>
                <dd>The content of the SMS being sent.</dd>

                <dt>Send as long SMS</dt>
                <dd>Only select this option when sending a message longer that 160 characters.</dd>
            </dl>
        </div>
    </div>

</div>