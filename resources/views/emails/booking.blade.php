<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>{{ __('booking.email_heading') }}</title>
</head>

<body style="font-family: Arial, sans-serif; line-height: 1.6;">

    <h2>{{ __('booking.email_heading') }}</h2>

    <p><strong>{{ __('booking.email_name') }}:</strong> {{ $data['name'] }}</p>
    <p><strong>{{ __('booking.email_email') }}:</strong> {{ $data['email'] }}</p>
    <p><strong>{{ __('booking.email_phone') }}:</strong> {{ $data['phone'] }}</p>
    <p><strong>{{ __('booking.email_nationality') }}:</strong> {{ $data['nationality'] }}</p>
    <p><strong>{{ __('booking.email_persons') }}:</strong> {{ $data['persons'] }}</p>
    <p><strong>{{ __('booking.email_date') }}:</strong> {{ $data['date'] }}</p>
    <p><strong>{{ __('booking.email_time') }}:</strong> {{ $data['time'] }}</p>
    <p><strong>{{ __('booking.email_total') }}:</strong> ${{ $data['total'] }}</p>

</body>

</html>