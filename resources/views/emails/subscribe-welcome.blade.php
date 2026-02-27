<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>{{ __('subscribe.email_subject') }}</title>
</head>

<body style="margin:0; padding:0; background-color:#f4f6f9; font-family:Arial, sans-serif;">

    <table width="100%" cellpadding="0" cellspacing="0" style="padding:40px 0;">
        <tr>
            <td align="center">

                <table width="600" cellpadding="0" cellspacing="0"
                    style="background:#ffffff; border-radius:10px; overflow:hidden; box-shadow:0 4px 20px rgba(0,0,0,0.05);">

                    {{-- HEADER --}}
                    <tr>
                        <td style="background:#0f172a; padding:30px; text-align:center; color:#ffffff;">

                            <img src="cid:logo" alt="Aventura506 Logo" width="80"
                                style="display:block; margin:0 auto 15px auto;">

                            <h1 style="margin:0; font-size:22px;">
                                Aventura506
                            </h1>

                            <p style="margin:8px 0 0 0; font-size:14px; opacity:0.9;">
                                {{ __('subscribe.email_header') }}
                            </p>

                        </td>
                    </tr>

                    {{-- BODY --}}
                    <tr>
                        <td style="padding:30px;">

                            <h2 style="margin-top:0; color:#0f172a;">
                                {{ __('subscribe.email_welcome_title') }}
                            </h2>

                            <p style="font-size:14px; line-height:1.6; color:#374151;">
                                {{ __('subscribe.email_welcome_text_1') }}
                            </p>

                            <p style="font-size:14px; line-height:1.6; color:#374151;">
                                {{ __('subscribe.email_welcome_text_2') }}
                            </p>

                            <div style="margin:25px 0; text-align:center;">
                                <a href="{{ url('/') }}"
                                    style="background:#16a34a; color:white; padding:12px 25px; text-decoration:none; border-radius:6px; font-size:14px;">
                                    {{ __('subscribe.email_cta') }}
                                </a>
                            </div>

                            <p style="font-size:13px; color:#6b7280;">
                                {{ __('subscribe.email_footer_text') }}
                            </p>

                        </td>
                    </tr>

                    {{-- FOOTER --}}
                    <tr>
                        <td style="background:#f9fafb; padding:20px; text-align:center; font-size:12px; color:#6b7280;">
                            © {{ date('Y') }} Aventura506 · La Fortuna, Costa Rica
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>