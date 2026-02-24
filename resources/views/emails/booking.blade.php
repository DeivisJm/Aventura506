<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>{{ __('booking.email_new_booking') }}</title>
</head>

<body style="margin:0; padding:0; background-color:#f4f6f9; font-family:Arial, sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f6f9; padding:40px 0;">
        <tr>
            <td align="center">

                <table width="600" cellpadding="0" cellspacing="0"
                    style="background:#ffffff; border-radius:10px; overflow:hidden; box-shadow:0 4px 20px rgba(0,0,0,0.05);">

                    {{-- HEADER --}}
                    <tr>
                        <td style="background:#0f172a; padding:30px; text-align:center;">

                            <div style="color:#ffffff !important;">

                                <img src="cid:logo" alt="Aventura506 Logo" width="80"
                                    style="display:block; margin:0 auto 15px auto;">

                                <h1 style="margin:0; font-size:22px; font-weight:bold; color:#ffffff !important;">
                                    Aventura506
                                </h1>

                                <p style="margin:8px 0 0 0; font-size:14px; opacity:0.9; color:#ffffff !important;">
                                    {{ __('booking.email_new_booking') }}
                                </p>

                            </div>

                        </td>
                    </tr>

                    {{-- BODY --}}
                    <tr>
                        <td style="padding:30px;">

                            <h2 style="margin-top:0; color:#0f172a;">
                                {{ __('booking.email_details') }}
                            </h2>

                            <table width="100%" cellpadding="10" cellspacing="0"
                                style="border-collapse:collapse; font-size:14px;">

                                <tr>
                                    <td><strong>{{ __('booking.email_company') }}</strong></td>
                                    <td>
                                        {{ is_array($booking->tour->company_name ?? null)
                                            ? ($booking->tour->company_name[app()->getLocale()] ?? $booking->tour->company_name['es'] ?? '')
                                            : ($booking->tour->company_name ?? 'Aventura506') }}
                                    </td>
                                </tr>

                                <tr style="background:#f9fafb;">
                                    <td width="40%"><strong>{{ __('booking.email_tour') }}</strong></td>
                                    <td>
                                        {{ is_array($booking->tour->name)
                                            ? ($booking->tour->name[app()->getLocale()] ?? $booking->tour->name['es'] ?? '')
                                            : $booking->tour->name }}
                                    </td>
                                </tr>

                                <tr style="background:#f9fafb;">
                                    <td><strong>{{ __('booking.email_name') }}</strong></td>
                                    <td>{{ $booking->guest_name }}</td>
                                </tr>

                                <tr>
                                    <td><strong>{{ __('booking.email_email') }}</strong></td>
                                    <td>{{ $booking->guest_email }}</td>
                                </tr>

                                <tr style="background:#f9fafb;">
                                    <td><strong>{{ __('booking.email_phone') }}</strong></td>
                                    <td>{{ $booking->guest_phone }}</td>
                                </tr>

                                <tr>
                                    <td><strong>{{ __('booking.email_nationality') }}</strong></td>
                                    <td>{{ $booking->guest_nationality }}</td>
                                </tr>

                                <tr style="background:#f9fafb;">
                                    <td><strong>{{ __('booking.email_date') }}</strong></td>
                                    <td>{{ $booking->formatted_date }}</td>
                                </tr>

                                <tr>
                                    <td><strong>{{ __('booking.email_time') }}</strong></td>
                                    <td>{{ $booking->time }}</td>
                                </tr>

                                @if($booking->notes)
                                <tr style="background:#f9fafb;">
                                    <td><strong>{{ __('booking.additional_notes') }}</strong></td>
                                    <td>{{ $booking->notes }}</td>
                                </tr>
                                @endif

                                {{-- DESGLOSE --}}
                                <tr>
                                    <td><strong>{{ __('booking.email_persons') }}</strong></td>
                                    <td>
                                        @foreach($booking->details as $detail)
                                        {{ is_array($detail->tourPrice->type)
                                                ? ($detail->tourPrice->type[app()->getLocale()] ?? $detail->tourPrice->type['es'] ?? '')
                                                : $detail->tourPrice->type }}
                                        ({{ $detail->quantity }})<br>
                                        @endforeach
                                    </td>
                                </tr>

                                <tr>
                                    <td><strong>{{ __('booking.email_total') }}</strong></td>
                                    <td style="font-size:16px; font-weight:bold; color:#16a34a;">
                                        ${{ number_format($booking->total, 2) }}
                                    </td>
                                </tr>

                            </table>

                        </td>
                    </tr>

                    {{-- FOOTER --}}
                    <tr>
                        <td style="background:#f9fafb; padding:20px; text-align:center; font-size:12px; color:#6b7280;">
                            © {{ date('Y') }} Aventura506 · La Fortuna, Costa Rica<br>
                            {{ __('booking.email_footer') }}
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>