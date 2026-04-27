<?php

namespace App\Mail;

use App\Models\Chapter;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ChapterApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Chapter $chapter,
        public string $studentName
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: "Chapter Approved: {$this->chapter->chapter_name}",
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.chapter-approved',
            with: [
                'chapter' => $this->chapter,
                'studentName' => $this->studentName,
                'supervisorComment' => $this->chapter->supervisor_comment,
                'dashboardUrl' => route('dashboard'),
            ]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
