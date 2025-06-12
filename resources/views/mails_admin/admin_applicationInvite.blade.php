<!DOCTYPE html>
<html>
<head>
    <title>Walk-In Interview Invitation</title>
    <meta charset="UTF-8">
</head>
<body style="font-family: Arial, sans-serif; background-color: #f9f9f9; padding: 30px; color: #333;">

    <div style="max-width: 600px; margin: auto; background-color: #ffffff; padding: 25px 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);">

        <h1 style="color: #2c3e50;">Hello {{ $applicant->first_name }},</h1>

        <p style="font-size: 16px; line-height: 1.6;">
            Thank you for your interest in joining <strong>Kou Fu Color Printing Corporation</strong>. We are pleased to invite you for a walk-in interview as part of the next phase in our hiring process.
        </p>

        <p style="font-size: 16px; line-height: 1.6;">
            <strong>Interview Schedule:</strong><br>
            📅 <strong>{{ \Carbon\Carbon::parse($interviewDate)->format('F j, Y') }}</strong><br>
            ⏰ <strong>{{ \Carbon\Carbon::parse($interviewDate)->format('g:i A') }}</strong><br>
            📍 <strong>Lots 6-7, Block 3, Phase 2, Mountview Industrial Complex, 4116 Carmona. 
                    <a href="https://www.google.com/maps/place/Kou+Fu+Color+Printing+Corporation/@14.2899638,121.0151067,17z/data=!3m1!4b1!4m6!3m5!1s0x3397d6395d343693:0xa194166d0396b739!8m2!3d14.2899638!4d121.0176816!16s%2Fg%2F1hc77vq9j?entry=ttu&g_ep=EgoyMDI1MDUxNS4wIKXMDSoASAFQAw%3D%3D">
                        Click for Google Maps
                    </a>
                </strong>
        </p>

        <p style="font-size: 16px; line-height: 1.6;">
            Please bring a copy of your Resume and any Valid ID.
        </p>

        <p style="font-size: 15px;">
            If you have any questions, feel free to contact us at 
            <a href="mailto:koufu@koufuprinting.com">koufu@koufuprinting.com</a>.
        </p>

        <p style="margin-top: 40px; font-size: 15px;">
            We look forward to meeting you!<br>
            <strong>Kou Fu Color Printing Corporation</strong>
        </p>

        <p style="margin-top: 40px; font-size: 13px; color: #999; border-top: 1px solid #eee; padding-top: 10px;">
            Please do not reply to this email. This inbox is not monitored.
        </p>

    </div>

</body>
</html>
