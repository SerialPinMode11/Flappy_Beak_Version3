<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactForm;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ControllerName extends Controller
{
    public function contactUs()
    {
        return view('guest.contact');
    }

    public function index()
    {
        $contactDatas = ContactForm::paginate(10);
        return view('admin.contacts.index', compact('contactDatas'));
    }

    public function customerAccounts()
    {
        $search = trim((string) request('q', ''));
        $nameSort = strtolower((string) request('name_sort', ''));

        $customersQuery = User::query()
            ->select(['id', 'name', 'email', 'phone', 'city', 'created_at', 'email_verified_at']);

        if ($search !== '') {
            $customersQuery->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%')
                    ->orWhere('city', 'like', '%' . $search . '%');

                $searchDate = date('Y-m-d', strtotime($search));
                if ($searchDate && $searchDate !== '1970-01-01') {
                    $query->orWhereDate('created_at', $searchDate);
                }
            });
        }

        if (in_array($nameSort, ['asc', 'desc'], true)) {
            $customersQuery->orderBy('name', $nameSort)->orderBy('id', 'asc');
        } else {
            // Default order begins from first account by ID.
            $customersQuery->orderBy('id', 'asc');
        }

        $customers = $customersQuery->paginate(12)->withQueryString();

        return view('admin.contacts.customers', compact('customers'));
    }

    public function contactPost(Request $request){
        $validatedData = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        try {
            ContactForm::create($validatedData);
            return redirect()->route('contact')->with('success', 'Thank you for contacting us!');
        } catch (\Exception $e) {
            return redirect()->route('contact')->with('error', 'An error occurred. Please try again.');
        }
    }

    public function aboutUs(){
        return view("customer.about");
    }

    public function sendReply(Request $request)
    {
        $validatedData = $request->validate([
            'contact_id' => 'required|exists:contactforms,id',
            'receiver_email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message_body' => 'required|string',
        ]);

        try {
            $brandName = 'Flappy-Beak';
            $safeSubject = e($validatedData['subject']);
            $safeBody = $this->sanitizeReplyBody($validatedData['message_body']);
            $year = now()->format('Y');

            $styledHtml = <<<HTML
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>{$safeSubject}</title>
</head>
<body style="margin:0;padding:0;background:#f3f4f6;font-family:Arial,Helvetica,sans-serif;color:#111827;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#f3f4f6;padding:24px 12px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="max-width:680px;background:#ffffff;border-radius:14px;overflow:hidden;border:1px solid #e5e7eb;">
                    <tr>
                        <td style="background:linear-gradient(135deg,#2563eb,#1d4ed8);padding:22px 28px;">
                            <h1 style="margin:0;font-size:20px;line-height:1.3;color:#ffffff;font-weight:700;">{$brandName}</h1>
                            <p style="margin:6px 0 0 0;font-size:13px;color:#dbeafe;">Customer Support Reply</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:24px 28px 10px 28px;">
                            <p style="margin:0 0 10px 0;font-size:12px;color:#6b7280;letter-spacing:.4px;text-transform:uppercase;">Subject</p>
                            <h2 style="margin:0 0 16px 0;font-size:21px;line-height:1.35;color:#111827;">{$safeSubject}</h2>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:0 28px 10px 28px;">
                            <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background:#f9fafb;border:1px solid #e5e7eb;border-radius:10px;">
                                <tr>
                                    <td style="padding:20px 18px;font-size:15px;line-height:1.75;color:#1f2937;">
                                        {$safeBody}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:18px 28px 26px 28px;">
                            <p style="margin:0;font-size:12px;color:#9ca3af;">This email was sent by {$brandName}. Please reply directly to continue the conversation.</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:14px 28px;background:#f9fafb;border-top:1px solid #e5e7eb;">
                            <p style="margin:0;font-size:11px;color:#9ca3af;">&copy; {$year} {$brandName}. All rights reserved.</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
HTML;

            Mail::send([], [], function ($message) use ($validatedData, $styledHtml) {
                $message
                    ->to($validatedData['receiver_email'])
                    ->subject($validatedData['subject'])
                    ->html($styledHtml);
            });

            ContactForm::whereKey($validatedData['contact_id'])->update([
                'replied_at' => now(),
            ]);

            return redirect()->route('contactforlist')->with('reply_success', 'Reply email sent successfully.');
        } catch (\Exception $e) {
            return redirect()->route('contactforlist')->with('reply_error', 'Failed to send reply email. Please check your mail setup and try again.');
        }
    }

    private function sanitizeReplyBody(string $messageBody): string
    {
        // Keep common rich text formatting from Quill while stripping unsafe tags.
        $allowedTags = '<p><br><strong><b><em><i><u><s><ul><ol><li><blockquote><pre><code><a><h1><h2><h3><h4><h5><h6><span><div>';
        $body = strip_tags($messageBody, $allowedTags);

        // Remove javascript: links for safety.
        $body = preg_replace('/href\s*=\s*([\'"])\s*javascript:[^\'"]*\1/i', 'href="#"', $body) ?? $body;

        // Ensure empty content does not break layout.
        if (!Str::of(strip_tags($body))->trim()->isNotEmpty()) {
            return '<p style="margin:0;">(No message content provided)</p>';
        }

        return $body;
    }
    
}
