<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation de mot de passe</title>
    <style>
        /* Styles généraux pour les clients de messagerie modernes */
        @media only screen and (max-width: 600px) {
            .container {
                width: 100% !important;
                padding: 0 !important;
            }

            .content {
                padding: 20px !important;
            }

            .button {
                font-size: 16px !important;
                padding: 12px !important;
            }
        }
    </style>
</head>

<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background-color: #f4f4f4;">

    <table border="0" cellpadding="0" cellspacing="0" width="100%" class="container">
        <!-- En-tête avec logo -->
        <tr>
            <td align="center" bgcolor="#007bff" style="padding: 20px 0;">
                <img src="{{ asset('storage/images/logo.png') }}" alt="Logo" width="100" height="auto"
                    style="display: block;">
            </td>
        </tr>

        <!-- Contenu principal -->
        <tr>
            <td align="center" bgcolor="#ffffff" style="padding: 20px;">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" class="content"
                    style="max-width: 600px; margin: auto;">
                    <tr>
                        <td align="center" style="padding: 20px 0; font-size: 24px; color: #333333;">
                            <p style="margin: 0;"><strong>Univerdog.site</strong></p>
                            <strong>Réinitialisation de votre mot de passe</strong>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding: 10px 0; font-size: 16px; color: #555555;">
                            Bonjour, veuillez cliquer sur le bouton ci-dessous pour réinitialiser votre mot de passe :
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding: 20px 0;">
                            <a href="{{ $resetUrl }}" class="button"
                                style="font-size: 16px; font-weight: bold; color: #ffffff; text-decoration: none; padding: 12px 24px; background-color: #007bff; border-radius: 4px; display: inline-block;">
                                Réinitialiser le mot de passe
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding: 10px 0; font-size: 14px; color: #555555;">
                            Ou copiez et collez ce lien dans votre navigateur :
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding: 10px 0; font-size: 14px; word-wrap: break-word;">
                            <a href="{{ $resetUrl }}"
                                style="color: #007bff; text-decoration: none;">{{ $resetUrl }}</a>
                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding: 20px 0; font-size: 14px; color: #555555;">
                            Ce lien est valable pendant 60 minutes.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <!-- Pied de page -->
        <tr>
            <td align="center" bgcolor="#f4f4f4" style="padding: 10px;">
                <p style="font-size: 12px; color: #aaaaaa; margin: 0;">&copy; {{ date('Y') }} Univerdog.site. Tous
                    droits réservés.</p>
            </td>
        </tr>
    </table>

</body>

</html>
