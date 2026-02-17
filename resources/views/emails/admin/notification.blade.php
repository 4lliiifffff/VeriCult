<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification from VeriCult Admin</title>
</head>
<body style="font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f8fafc; color: #334155; line-height: 1.6; margin: 0; padding: 0;">
    <div style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 12px; overflow: hidden; margin-top: 40px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);">
        <!-- Header -->
        <div style="background-color: #0077B6; padding: 30px; text-align: center;">
            <h1 style="color: #ffffff; margin: 0; font-size: 24px; font-weight: bold;">VeriCult</h1>
        </div>

        <!-- Content -->
        <div style="padding: 40px 30px;">
            <p style="font-size: 16px; margin-bottom: 20px;">Hello, <strong>{{ $user->name }}</strong>,</p>
            
            <p style="font-size: 16px; margin-bottom: 20px;">You have received a new notification from the administrator:</p>
            
            <div style="background-color: #f1f5f9; border-left: 4px solid #0077B6; padding: 20px; border-radius: 4px; margin-bottom: 30px;">
                <p style="margin: 0; font-style: italic; color: #475569;">"{{ $messageContent }}"</p>
            </div>

            <p style="font-size: 14px; color: #64748b;">
                Please do not reply to this email as it is automatically generated.
            </p>
        </div>

        <!-- Footer -->
        <div style="background-color: #f8fafc; padding: 20px; text-align: center; border-top: 1px solid #e2e8f0;">
            <p style="font-size: 12px; color: #94a3b8; margin: 0;">&copy; {{ date('Y') }} VeriCult. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
