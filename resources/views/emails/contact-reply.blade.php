<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $profile->name ?? 'Portfolio' }}</title>
</head>
<body style="margin:0; padding:0; background-color:#f4f4f3; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f4f4f3; padding:32px 16px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width:560px; background-color:#ffffff; border-radius:16px; overflow:hidden; border:1px solid #e5e5e3;">
                    <tr>
                        <td style="background-color:#0a0a0a; padding:24px 32px;">
                            <span style="color:#ffffff; font-size:16px; font-weight:600;">{{ $profile->name ?? 'Portfolio' }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:32px;">
                            <p style="margin:0 0 16px; color:#171717; font-size:15px; line-height:1.6;">
                                Hi {{ $contactMessage->name }},
                            </p>

                            <div style="margin:0 0 24px; color:#171717; font-size:15px; line-height:1.7;">
                                <style>
                                    .reply-content p { margin: 0 0 1em; }
                                    .reply-content p:last-child { margin-bottom: 0; }
                                    .reply-content ul, .reply-content ol { margin: 0 0 1em; padding-left: 1.4em; }
                                    .reply-content a { color: #059669; }
                                    .reply-content blockquote { margin: 0 0 1em; padding-left: 12px; border-left: 3px solid #d4d4d4; color: #57534e; }
                                </style>
                                <div class="reply-content">{!! $replyBody !!}</div>
                            </div>

                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f7f7f6; border-radius:12px; margin-bottom:8px;">
                                <tr>
                                    <td style="padding:16px 20px;">
                                        <p style="margin:0 0 6px; color:#8a8a85; font-size:11px; text-transform:uppercase; letter-spacing:0.05em;">Your original message</p>
                                        @if($contactMessage->subject)
                                            <p style="margin:0 0 6px; color:#171717; font-size:13px; font-weight:600;">{{ $contactMessage->subject }}</p>
                                        @endif
                                        <p style="margin:0; color:#57534e; font-size:13px; line-height:1.6; white-space:pre-line;">{{ $contactMessage->message }}</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:20px 32px; border-top:1px solid #ececea;">
                            <p style="margin:0; color:#8a8a85; font-size:12px;">
                                Sent from {{ $profile->name ?? 'my portfolio' }}'s contact form.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
