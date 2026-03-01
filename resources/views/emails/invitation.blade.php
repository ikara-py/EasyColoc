<!DOCTYPE html>
<html>

<head>
    <title>Invitation</title>
</head>

<body>
    <p>Hello,</p>

    <p>You have been invited to join <strong>{{ $invitation->colocation->name }}</strong>.</p>

    <p><strong>Option 1:</strong> Click the link below to join directly:</p>
    <p><a href="{{ route('invitations.accept', $invitation->token) }}">{{ route('invitations.accept', $invitation->token) }}</a></p>

    <p><strong>Option 2:</strong> Copy and paste this invite code in the app:</p>
    <p style="font-size: 20px; font-weight: bold; letter-spacing: 2px;">{{ $invitation->token }}</p>

    <br>
</body>

</html>