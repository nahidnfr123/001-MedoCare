@component('mail::message')

    <p><b>Hello, </b> {!! $data['name'] !!}!</p><br>
    <p><b>Subject:</b> {!! $data['message_subject'] !!}</p>

    @component('mail::panel')
        <div>
            <p><b>Your query:</b> {!! $data['received_message'] !!}</p>
        </div>
    @endcomponent

    @component('mail::panel')
        <div class="text-justify">
            <p><b>Reply:</b> {!! $data['message_body'] !!}</p>
        </div>
    @endcomponent

    {{--@component('mail::button', ['url' => '', 'color' => 'green'])
    Button Text
    @endcomponent--}}

    <br><br>
    <hr>

<h3>Thanks for getting connected to us,<br>
{{ config('app.name') }}
</h3>

@endcomponent

