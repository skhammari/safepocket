@component('mail::message')
# Complete Your Registration

Thank you for signing up! To complete your registration, please click the button below to set up your username and password.

@component('mail::button', ['url' => $verificationUrl])
Complete Registration
@endcomponent

This link will expire in 24 hours.

If you did not create an account, no further action is required.

Thanks,<br>
{{ config('app.name') }}
@endcomponent 