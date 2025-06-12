<!DOCTYPE html>
<html>
<head>
    <title>Application Sent</title>
    <meta charset="UTF-8">
</head>
<body style="font-family: Arial, sans-serif; background-color: #f9f9f9; padding: 30px; color: #333;">

    <div style="max-width: 600px; margin: auto; background-color: #ffffff; padding: 25px 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);">

        <h1 style="color: #2c3e50;">Hi {{ $applicant->first_name }},</h1>

        <p style="font-size: 16px; line-height: 1.6;">
            Thank you for applying for the position of 
            <strong style="color: #2980b9;">{{ $applicant->selected_position }}</strong> at Kou Fu Color Printing Corporation.
            We have received your application and our team will review it shortly.
        </p>

        <div style="margin-top: 20px;">
            <h3 style="color: #34495e; border-bottom: 1px solid #eee; padding-bottom: 5px;">Application Details</h3>
            <ul style="list-style: none; padding-left: 0; font-size: 15px; line-height: 1.8;">
                <li><strong>Full Name:</strong> {{ $applicant->first_name }} {{ $applicant->last_name }}</li>
                <li><strong>Email:</strong> {{ $applicant->email }}</li>
                <li><strong>Phone Number:</strong> {{ $applicant->contact }}</li>
                <li><strong>Subject:</strong> {{ $applicant->subject }}</li>
                <li><strong>Message:</strong> {{ $applicant->mssg }}</li>
            </ul>
        </div>

        <p style="margin-top: 30px; font-size: 15px;">
            If you have any questions regarding your application, feel free to contact us at 
            <a href="mailto:koufu@koufuprinting.com">hr.recruitment@koufuprinting.com</a>.
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
