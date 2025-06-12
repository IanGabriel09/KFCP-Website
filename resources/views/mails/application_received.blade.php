<!DOCTYPE html>
<html>
<head>
    <title>New Application Received</title>
    <meta charset="UTF-8">
</head>
<body style="font-family: Arial, sans-serif; background-color: #f9f9f9; padding: 30px; color: #333;">

    <div style="max-width: 600px; margin: auto; background-color: #ffffff; padding: 25px 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);">

        <h1 style="color: #2c3e50;">New Job Application Received</h1>

        <p style="font-size: 16px; line-height: 1.6;">
            A new application has been submitted for the position of 
            <strong style="color: #2980b9;">{{ $applicant->selected_position }}</strong> at Kou Fu Color Printing Corporation.
        </p>

        <div style="margin-top: 20px;">
            <h3 style="color: #34495e; border-bottom: 1px solid #eee; padding-bottom: 5px;">Applicant Details</h3>
            <ul style="list-style: none; padding-left: 0; font-size: 15px; line-height: 1.8;">
                <li><strong>Full Name:</strong> {{ $applicant->first_name }} {{ $applicant->last_name }}</li>
                <li><strong>Email:</strong> {{ $applicant->email }}</li>
                <li><strong>Phone Number:</strong> {{ $applicant->contact }}</li>
                <li><strong>Subject:</strong> {{ $applicant->subject }}</li>
                <li><strong>Message:</strong> {{ $applicant->mssg }}</li>
            </ul>
        </div>

        @php
            $isLocal = request()->getHost() === '127.0.0.1' || request()->getHost() === 'localhost';
        @endphp

        <a href="{{ $isLocal ? route('admin.open-positions') : rtrim(config('services.koufu.custom_app_url'), '/') . '/admin/open-positions' }}">
            KFCP Admin Dashboard
        </a>


        <p style="margin-top: 40px; font-size: 15px;">
            Regards,<br>
            <strong>KFCP MIS Team</strong>
        </p>

        <p style="margin-top: 40px; font-size: 13px; color: #999; border-top: 1px solid #eee; padding-top: 10px;">
            Please do not reply to this email. This inbox is not monitored.
        </p>

    </div>

</body>
</html>
