<!DOCTYPE html>
<html>
<head>
    <title>Application Update</title>
    <meta charset="UTF-8">
</head>
<body style="font-family: Arial, sans-serif; background-color: #f9f9f9; padding: 30px; color: #333;">

    <div style="max-width: 600px; margin: auto; background-color: #ffffff; padding: 25px 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);">

        <h1 style="color: #2c3e50;">Congratulations {{ $applicant->first_name }},</h1>

        <p style="font-size: 16px; line-height: 1.6;">
            We are pleased to inform you that you have successfully passed the initial screening at Kou Fu Color Printing Corporation.
        </p>

        <p style="font-size: 16px; line-height: 1.6;">
            To proceed to the next step in our hiring process, please complete the application form at the link below:
        </p>

        <p style="margin: 20px 0; font-size: 16px;">
            👉 <a href="https://example.com/" style="color: #3498db;">https://example.com/</a>
        </p>

        <p style="font-size: 15px;">
            If you have any questions or need assistance, feel free to reach out to us at 
            <a href="mailto:koufu@koufuprinting.com">koufu@koufuprinting.com</a>.
        </p>

        <p style="margin-top: 40px; font-size: 15px;">
            Best regards,<br>
            <strong>Kou Fu Color Printing Corporation</strong>
        </p>

        <p style="margin-top: 40px; font-size: 13px; color: #999; border-top: 1px solid #eee; padding-top: 10px;">
            Please do not reply to this email. This inbox is not monitored.
        </p>

    </div>

</body>
</html>
