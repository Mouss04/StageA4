<!DOCTYPE html>
<html>

<head>
    <title>Votre compte a été créé</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f3f4f6; margin: 0; padding: 20px; text-align: center;">

    <div style="max-width: 600px; background-color: #ffffff; margin: auto; padding: 20px; border-radius: 10px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">

        <h2 style="color: #1f2937;">🎉 Votre compte a été créé !</h2>

        <p style="color: #374151;">Bonjour <strong>{{ $user->full_name }}</strong>,</p>

        <p style="color: #4b5563;">Votre compte a été créé avec succès. Voici vos identifiants :</p>

        <div style="background-color: #f9fafb; padding: 10px; border-radius: 5px; text-align: left; margin: 20px 0;">
            <p><strong>Email :</strong> {{ $user->email }}</p>
            <p><strong>Mot de passe :</strong> {{ $password }}</p>
        </div>

        <p style="color: #6b7280;">Nous vous recommandons de changer votre mot de passe après connexion.</p>

        <p style="color: #374151;">📌 Vous pouvez également scanner ce QR Code pour vérifier votre compte :</p>
        <img src="{{ asset('storage/qrcodes/user_' . $user->id . '.png') }}" alt="QR Code" style="width: 150px; margin: 10px auto; display: block; border-radius: 5px;">

        <p style="color: #6b7280; margin-top: 20px;">Cordialement,</p>
        <p style="color: #6b7280;">L'équipe</p>

    </div>

</body>

</html>
