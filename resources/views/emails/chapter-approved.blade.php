<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chapter Approved</title>
</head>
<body style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; line-height: 1.6; color: #374151; margin: 0; padding: 0; background-color: #f9fafb;">
    <div style="max-width: 600px; margin: 0 auto; background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
        <div style="background: #f59e0b; color: white; padding: 32px; text-align: center;">
            <h1 style="margin: 0; font-size: 24px; font-weight: 600;">🎉 Chapter Approved!</h1>
        </div>
        
        <div style="padding: 32px;">
            <div style="width: 48px; height: 48px; background: #10b981; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px; color: white; font-size: 24px;">✓</div>
            
            <p>Dear {{ $studentName ?? 'Student' }},</p>
            
            <p>Great news! Your supervisor has approved your chapter. Your hard work has been recognized and you can proceed with confidence.</p>
            
            <div style="background: #fef3c7; border-left: 4px solid #f59e0b; padding: 16px; margin: 24px 0; border-radius: 0 4px 4px 0;">
                <div style="font-weight: 600; color: #92400e; margin-bottom: 8px;">{{ $chapter->chapter_name }}</div>
                <div>Approved on: {{ $chapter->updated_at->format('F j, Y \a\t g:i A') }}</div>
            </div>
            
            @if($supervisorComment)
            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 20px; margin: 24px 0;">
                <span style="font-weight: 600; color: #4f46e5; margin-bottom: 12px; display: block;">Supervisor's Feedback:</span>
                <div style="color: #64748b; white-space: pre-wrap;">{{ $supervisorComment }}</div>
            </div>
            @endif
            
            <div style="text-align: center;">
                <a href="{{ $dashboardUrl }}" style="display: inline-block; background: #4f46e5; color: white; text-decoration: none; padding: 12px 24px; border-radius: 6px; font-weight: 500; text-align: center; margin: 24px 0;">View Your Dashboard</a>
            </div>
            
            <p>Keep up the excellent work with your project!</p>
            
            <p>Best regards,<br>The ProjectHub Team</p>
        </div>
        
        <div style="background: #f8fafc; padding: 24px 32px; text-align: center; border-top: 1px solid #e2e8f0; color: #64748b; font-size: 14px;">
            <p style="margin: 0;">This is an automated message from ProjectHub. Please do not reply to this email.</p>
        </div>
    </div>
</body>
</html>
