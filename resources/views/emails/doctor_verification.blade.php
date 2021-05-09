@component('mail::message')
# Account activation / verification...

Hello, Dr. {{ $User->first_name .' '. $User->last_name}}!

Your account was reviewed by our admin and your join request was accepted based on the data you have provided.
Thanks for joining our community. Your participation will be very helpful for us, stay connected.


You should now activate your account by clicking the verify button below.

@php $url = url('verify-email|') . $User->doctor->email_verification_token; @endphp

@component('mail::button', ['url' => $url, 'color' => 'success'])
Verify
@endcomponent

If you are watching this by mistake please ignore this email.

@component('mail::panel')
    <p>If you are having trouble with the verify button above you may click the link below.</p>
    {{ $url }}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
