<!DOCTYPE html>
<html>
<head>
    <title>New Inquiry Received</title>
    <meta charset="UTF-8">
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 30px; color: #333;">

    <div style="max-width: 600px; margin: auto; background-color: #ffffff; padding: 25px 30px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);">

        <h2 style="color: #2c3e50;">📩 New Product Inquiry Received</h2>

        <p style="font-size: 16px; line-height: 1.6;">
            A new inquiry has been submitted. Below are the details:
        </p>

        <div style="margin-top: 20px;">
            <h3 style="color: #34495e; border-bottom: 1px solid #eee; padding-bottom: 5px;">Inquiry Information</h3>
            <ul style="list-style: none; padding-left: 0; font-size: 15px; line-height: 1.8;">
                <li><strong>Name:</strong> {{ $inquiry->name }}</li>
                <li><strong>Email:</strong> {{ $inquiry->email }}</li>
                <li><strong>Phone Number:</strong> {{ $inquiry->contact }}</li>
                <li><strong>Subject:</strong> {{ $inquiry->subject }}</li>
                <li><strong>Message:</strong> {{ $inquiry->mssg }}</li>
            </ul>
        </div>

        <p style="margin-top: 30px; font-size: 15px;">
            Please respond to this inquiry as soon as possible. You can reply directly to the sender at 
            <a href="mailto:{{ $inquiry->email }}">{{ $inquiry->email }}</a>.
        </p>

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
