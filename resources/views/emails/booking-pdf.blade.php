<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>{{ __('booking.email_subject') }}</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 0;
            padding: 40px;
            background: #ffffff;
        }

        .container {
            width: 100%;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #16a34a;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .logo {
            width: 90px;
            margin-bottom: 10px;
        }

        .title {
            font-size: 22px;
            font-weight: bold;
            margin: 0;
        }

        .subtitle {
            font-size: 14px;
            color: #555;
            margin-top: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        td {
            padding: 12px 0;
            font-size: 14px;
            border-bottom: 1px solid #ddd;
        }

        .label {
            font-weight: bold;
            width: 40%;
        }

        .total-row td {
            border-bottom: none;
            padding-top: 20px;
        }

        .total {
            font-size: 18px;
            font-weight: bold;
            color: #16a34a;
        }

        .footer {
            margin-top: 40px;
            font-size: 11px;
            text-align: center;
            color: #777;
        }
    </style>
</head>

<body>

    <div class="container">

        <div class="header">
            <img src="{{ public_path('images/logo.png') }}" class="logo">
            <div class="title">Aventura506</div>
            <div class="subtitle">
                {{ __('booking.email_new_booking') }}
            </div>
        </div>

        <table>
            <tr>
                <td class="label">{{ __('booking.email_name') }}</td>
                <td>{{ $data['name'] }}</td>
            </tr>

            <tr>
                <td class="label">{{ __('booking.email_email') }}</td>
                <td>{{ $data['email'] }}</td>
            </tr>

            <tr>
                <td class="label">{{ __('booking.email_phone') }}</td>
                <td>{{ $data['phone'] }}</td>
            </tr>

            <tr>
                <td class="label">{{ __('booking.email_nationality') }}</td>
                <td>{{ $data['nationality'] }}</td>
            </tr>

            <tr>
                <td class="label">{{ __('booking.email_persons') }}</td>
                <td>{{ $data['persons'] }}</td>
            </tr>

            <tr>
                <td class="label">{{ __('booking.email_date') }}</td>
                <td>{{ $data['date'] }}</td>
            </tr>

            <tr>
                <td class="label">{{ __('booking.email_time') }}</td>
                <td>{{ $data['time'] }}</td>
            </tr>

            <tr class="total-row">
                <td class="label">{{ __('booking.email_total') }}</td>
                <td class="total">${{ $data['total'] }}</td>
            </tr>
        </table>

        <div class="footer">
            © {{ date('Y') }} Aventura506 · La Fortuna, Costa Rica<br>
            {{ __('booking.email_footer') }}
        </div>

    </div>

</body>

</html>