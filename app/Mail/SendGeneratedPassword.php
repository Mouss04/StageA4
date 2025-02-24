<?php
namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class SendGeneratedPassword extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $password;
    public $qrCodePath;

    public function __construct(User $user, $password)
    {
        $this->user = $user;
        $this->password = $password;

        // Define the QR Code path within the public disk
        $this->qrCodePath = "qrcodes/user_{$user->id}.png";

        // Generate QR Code with a verification link
        $qrCodeData = route('verify.qr', ['id' => $user->id]);
        $qrCodeImage = QrCode::format('png')->size(300)->generate($qrCodeData);

        // Ensure the 'qrcodes' directory exists in public storage
        Storage::disk('public')->put($this->qrCodePath, $qrCodeImage);
    }

    public function build()
    {
        return $this->subject('Your Account Details')
                    ->view('emails.generated_password')
                    ->attach(public_path("storage/" . $this->qrCodePath), [
                       'as' => 'qrcode.png',
                       'mime' => 'image/png',
                    ])
                ;
    }
}

