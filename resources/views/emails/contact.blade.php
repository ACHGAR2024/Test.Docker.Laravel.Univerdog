<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message de Contact</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background-color: #f2f2f2;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
            margin-bottom: 12px;
        }

        .info {
            margin-bottom: 20px;
        }

        .info p {
            margin: 0;
        }

        .message {
            margin-bottom: 20px;
        }

        .message p {
            margin: 0;
            font-size: 16px;
            line-height: 1.8;
        }

        .footer p {
            text-align: center;
            font-size: 10px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <h4>Sujet : {{ $subject }}</h4>
        <div class="info">
            <p>Le {{ \Carbon\Carbon::now()->format('Y-m-d H:i') }}</p>
        </div>
        <div class="message">
            <p>Message de {{ $name }}</p>
            <p>{{ $messageContent }}</p>
        </div>
        <div class="footer">
            <p>Cet email a été envoyé à partir du formulaire de contact de https://univerdog.site.</p>
        </div>
    </div>
</body>
</html>