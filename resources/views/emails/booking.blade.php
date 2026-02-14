<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>New Booking Request</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6;">

    <h2>New Booking Received</h2>

    <p><strong>Name:</strong> {{ $data['name'] }}</p>
    <p><strong>Email:</strong> {{ $data['email'] }}</p>
    <p><strong>Phone:</strong> {{ $data['phone'] }}</p>
    <p><strong>Nationality:</strong> {{ $data['nationality'] }}</p>
    <p><strong>Persons:</strong> {{ $data['persons'] }}</p>
    <p><strong>Date:</strong> {{ $data['date'] }}</p>
    <p><strong>Time:</strong> {{ $data['time'] }}</p>
    <p><strong>Total:</strong> ${{ $data['total'] }}</p>

</body>
</html>
