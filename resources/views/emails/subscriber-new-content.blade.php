<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>{{ __('subscriber_notifications.email_subject') }}</title>
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
                                {{ __('subscriber_notifications.email_header') }}
                            </p>

                        </td>
                    </tr>

                    {{-- BODY --}}
                    <tr>
                        <td style="padding:30px;">

                            <h2 style="margin-top:0; color:#0f172a;">
                                {{ __('subscriber_notifications.email_title') }}
                            </h2>

                            <p style="font-size:14px; line-height:1.6; color:#374151; margin-bottom:24px;">
                                {{ __('subscriber_notifications.email_intro') }}
                            </p>

                            {{-- Spanish block --}}
                            <div style="margin-bottom:28px; padding:20px; background:#f9fafb; border-radius:10px; border:1px solid #e5e7eb;">
                                <p style="margin:0 0 10px 0; font-size:12px; font-weight:bold; text-transform:uppercase; letter-spacing:0.08em; color:#16a34a;">
                                    Español
                                </p>

                                <p style="margin:0 0 10px 0; font-size:13px; color:#6b7280;">
                                    {{ $content['type_es'] }}
                                </p>

                                <h3 style="margin:0 0 12px 0; color:#0f172a; font-size:22px;">
                                    {{ $content['title_es'] }}
                                </h3>

                                <p style="margin:0; font-size:14px; line-height:1.7; color:#374151;">
                                    {{ $content['description_es'] }}
                                </p>
                            </div>

                            {{-- English block --}}
                            <div style="margin-bottom:28px; padding:20px; background:#f9fafb; border-radius:10px; border:1px solid #e5e7eb;">
                                <p style="margin:0 0 10px 0; font-size:12px; font-weight:bold; text-transform:uppercase; letter-spacing:0.08em; color:#16a34a;">
                                    English
                                </p>

                                <p style="margin:0 0 10px 0; font-size:13px; color:#6b7280;">
                                    {{ $content['type_en'] }}
                                </p>

                                <h3 style="margin:0 0 12px 0; color:#0f172a; font-size:22px;">
                                    {{ $content['title_en'] }}
                                </h3>

                                <p style="margin:0; font-size:14px; line-height:1.7; color:#374151;">
                                    {{ $content['description_en'] }}
                                </p>
                            </div>

                            <div style="margin:25px 0; text-align:center;">
                                <a href="{{ $content['url'] }}"
                                    style="background:#3f8b5f; color:white; padding:12px 25px; text-decoration:none; border-radius:8px; font-size:14px; display:inline-block;">
                                    {{ __('subscriber_notifications.email_cta') }}
                                </a>
                            </div>

                            <p style="font-size:13px; color:#6b7280; line-height:1.6;">
                                {{ __('subscriber_notifications.email_footer_text') }}
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