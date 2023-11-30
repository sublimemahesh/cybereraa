@extends('email.layouts.master')
@section('title', 'Profile Details Update Notification')
@section('content')
    <p>
        Dear {{ $user->username }},
    </p>
    <p>
        We are writing to inform you that your password on our platform has been changed from IP Address: {{ request()->ip() }}. This change was made on {{ $user->updated_at }}.
    </p>
    <p>
        If you authorized this change, there is no need to take any further action.
        if you did not authorize this change, change your password to a stronger one and enable two-factor authentication.
        However, if you have any concerns about the security of your account, please contact us immediately so that we can investigate the matter further.
    </p>
    <p>
        Please remember to keep your password secure and confidential. Do not share it with anyone,
        and avoid using easily guessable passwords.
    </p>
    <p>
        Thank you for using our platform. If you have any questions or concerns regarding this change,
        please feel free to contact us.
    </p>
    <p>
        Best regards,<br>
        coin1m.com Team.
    </p>
@endsection
