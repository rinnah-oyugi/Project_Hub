<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chapter Re-opened for Revision</title>
</head>
<body style="font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; line-height: 1.6; color: #374151; margin: 0; padding: 0; background-color: #f9fafb;">
    <div style="max-width: 600px; margin: 0 auto; background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);">
        <div style="background: #4f46e5; color: white; padding: 32px; text-align: center;">
            <h1 style="margin: 0; font-size: 24px; font-weight: 600;">📝 Chapter Re-opened for Revision</h1>
        </div>
        
        <div style="padding: 32px;">
            <div style="width: 48px; height: 48px; background: #f59e0b; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 24px; color: white; font-size: 24px;">↻</div>
            
            <p>Dear {{ $studentName ?? 'Student' }},</p>
            
            <p>Your supervisor has re-opened your chapter for revision. This is an opportunity to improve your work based on their feedback.</p>
            
            <div style="background: #fef3c7; border-left: 4px solid #f59e0b; padding: 16px; margin: 24px 0; border-radius: 0 4px 4px 0;">
                <div style="font-weight: 600; color: #92400e; margin-bottom: 8px;">{{ $chapter->chapter_name }}</div>
                <div>Re-opened on: {{ $chapter->updated_at->format('F j, Y \a\t g:i A') }}</div>
            </div>
            
            @if($supervisorComment)
            <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 20px; margin: 24px 0;">
                <span style="font-weight: 600; color: #4f46e5; margin-bottom: 12px; display: block;">Supervisor's Feedback:</span>
                <div style="color: #64748b; white-space: pre-wrap;">{{ $supervisorComment }}</div>
            </div>
            @endif
            
            <div style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 6px; padding: 16px; margin: 20px 0;">
                <h3 style="margin: 0 0 12px 0; color: #1e40af; font-size: 16px;">What to do next:</h3>
                <ol style="margin: 0; padding-left: 20px; color: #374151;">
                    <li style="margin-bottom: 8px;">Review your supervisor's feedback carefully</li>
                    <li style="margin-bottom: 8px;">Make the necessary revisions to your chapter</li>
                    <li style="margin-bottom: 8px;">Upload the revised version through your dashboard</li>
                    <li style="margin-bottom: 8px;">Submit for review again</li>
                </ol>
            </div>
            
            <div style="text-align: center;">
                <a href="{{ $dashboardUrl }}" style="display: inline-block; background: #f59e0b; color: white; text-decoration: none; padding: 12px 24px; border-radius: 6px; font-weight: 500; text-align: center; margin: 24px 0;">Go to Your Dashboard</a>
            </div>
            
            <p>Remember, revision is a normal part of the academic process. Take this feedback constructively and use it to strengthen your work.</p>
            
            <p>Best regards,<br>The ProjectHub Team</p>
        </div>
        
        <div style="background: #f8fafc; padding: 24px 32px; text-align: center; border-top: 1px solid #e2e8f0; color: #64748b; font-size: 14px;">
            <p style="margin: 0;">This is an automated message from ProjectHub. Please do not reply to this email.</p>
        </div>
    </div>
</body>
</html>
