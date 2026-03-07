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
            <img src="{{ public_path('images/logos/logo.png') }}" class="logo">
            <div class="title">Aventura506</div>
            <div class="subtitle">
                {{ __('booking.email_new_booking') }}
            </div>
        </div>

        <table>

            <tr>
                <td class="label">{{ __('booking.email_company') }}</td>
                <td>{{ $booking->tour->company->name ?? 'Aventura506' }}</td>
            </tr>

            <tr>
                <td class="label">{{ __('booking.email_tour') }}</td>
                <td>
                    {{ is_array($booking->tour->name)
                        ? ($booking->tour->name[app()->getLocale()] ?? $booking->tour->name['es'] ?? '')
                        : $booking->tour->name }}
                </td>
            </tr>

            <tr>
                <td class="label">{{ __('booking.email_name') }}</td>
                <td>{{ $booking->guest_name }}</td>
            </tr>

            <tr>
                <td class="label">{{ __('booking.email_email') }}</td>
                <td>{{ $booking->guest_email }}</td>
            </tr>

            <tr>
                <td class="label">{{ __('booking.email_phone') }}</td>
                <td>{{ $booking->guest_phone }}</td>
            </tr>

            <tr>
                <td class="label">{{ __('booking.email_nationality') }}</td>
                <td>{{ $booking->guest_nationality }}</td>
            </tr>

            <tr>
                <td class="label">{{ __('booking.email_date') }}</td>
                <td>{{ $booking->formatted_date }}</td>
            </tr>

            <tr>
                <td class="label">{{ __('booking.email_time') }}</td>
                <td>{{ $booking->time }}</td>
            </tr>

            <tr>
                <td class="label">{{ __('booking.email_persons') }}</td>
                <td>
                    @php
                    $validDetails = $booking->details->where('quantity', '>', 0);

                    $groupedDetails = $validDetails->groupBy(function($detail) {
                    return $detail->tourPrice->category_type;
                    });

                    $hasNational = $groupedDetails->has('national');
                    $hasInternational = $groupedDetails->has('international');
                    $showMarketTitles = $hasNational && $hasInternational;
                    @endphp

                    @foreach($groupedDetails as $market => $details)

                    @if($showMarketTitles)
                    <strong>
                        {{ $market === 'national'
                ? __('booking.national_option')
                : __('booking.international_option') }}
                    </strong>
                    <br>
                    @endif

                    @foreach($details as $detail)
                    - {{ $detail->tourPrice->getTranslatedType() }}
                    ({{ $detail->quantity }})
                    <br>
                    @endforeach

                    @if($showMarketTitles)
                    <br>
                    @endif

                    @endforeach
                </td>
            </tr>

            @if($booking->notes)
            <tr>
                <td class="label">{{ __('booking.additional_notes') }}</td>
                <td>{{ $booking->notes }}</td>
            </tr>
            @endif

            <tr class="total-row">
                <td class="label">{{ __('booking.email_total') }}</td>
                <td class="total">
                    {{ $booking->formatted_total }}
                </td>
            </tr>

        </table>

        <div class="footer">
            © {{ date('Y') }} Aventura506 · La Fortuna, Costa Rica<br>
            {{ __('booking.email_footer') }}
        </div>

    </div>

</body>

</html>