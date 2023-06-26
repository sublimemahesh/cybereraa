@extends('email.layouts.master')
@section('title', 'Rejection of Withdrawal Request')
@section('content')
    <p>
        Dear {{ $user->username }},
    </p>
    <p>
        We regret to inform you that your recent withdrawal request(#{{ str_pad($withdraw->id,5,0,STR_PAD_LEFT) }}) has been rejected by our team.
        The reason for rejection is {{ $withdraw->repudiate_note }}.
    </p>
    <p>
        We understand that this news may come as a disappointment to you, and we apologize for any inconvenience caused. However,
        we have taken this step to ensure the safety and security of your account and funds.
    </p>
    <p>
        If you require more information or have any questions about the rejection, please do not hesitate to contact our support team.
        You can create a new support ticket by clicking on the following link:
        <a href="https://www.owara3m.com/user/support/tickets/create">Open support ticket</a>
        We appreciate your understanding in this matter.
    </p>
    <p>
        Best regards,<br>
        Admin<br>
        owara3m.com
    </p>
@endsection

