@extends('email.layouts.master')
@section('title', 'Profile Details Update Notification')
@section('content')
    <p>
        Dear {{ $user->username }},
    </p> <p>
        We are writing to inform you that your profile details have been successfully updated on our platform.
        This update was made on {{ $user->updated_at }}.
    </p> <p>
        The following details have been changed:
    </p>
    <p>
        @foreach($dirty as $key => $detail)
            {{ ucfirst(str_replace('_',' ', $key)) }}: {{ $detail }} >> {{ $user->{$key} }}<br>
        @endforeach
        IP Address: {{ request()->ip() }}
    </p>
    <p>
        If you did not authorize these changes, Please change your password to a stronger one and enable two-factor authentication.
        However, if you have any concerns about the security of your account,
        please contact us immediately so that we can investigate the matter further.
    </p>
    <p>
        Thank you for keeping your information up-to-date with us. If you have any questions or concerns regarding this update,
        please feel free to contact us.
    </p>
    <p>
        Best regards,<br>
        owara3m.com Team.
    </p>
@endsection
