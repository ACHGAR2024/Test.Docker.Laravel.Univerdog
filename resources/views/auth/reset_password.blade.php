<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation du mot de passe</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <!-- Logo -->
        <div class="text-center mb-4">
            <img src="{{ asset('storage/images/logo.png') }}" alt="Logo" class="img-fluid"
                style="max-width: 150px;">
        </div>

        <!-- Formulaire de réinitialisation -->
        <div class="card shadow-sm mx-auto" style="width: 100%; max-width: 500px; margin-button: 100px;">
            <div class="card-body">
                <h4 class="card-title text-center mb-4">Réinitialisation du mot de passe</h4>

                <form id="resetForm" action="{{ route('password.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">

                    <div class="form-group">
                        <label for="email">Email</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            </div>
                            <input id="email" type="email" class="form-control" name="email"
                                value="{{ request()->query('email') }}" required autofocus>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password">Nouveau mot de passe</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            </div>
                            <input id="password" type="password" class="form-control" name="password"
                                pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,}$"
                                title="8 caractères minimum, une majuscule, un caractère spécial, un chiffre et une lettre."
                                required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation">Confirmer le mot de passe</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            </div>
                            <input id="password_confirmation" type="password" class="form-control"
                                name="password_confirmation" required>
                        </div>
                    </div>

                    <button id="submitBtn" type="submit" class="btn btn-primary btn-block">Réinitialiser le mot de
                        passe</button>
                </form>
            </div>

        </div>
        <br>
        <br>
        <br>
        <br>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!-- Custom JavaScript -->
    <script>
        document.getElementById('resetForm').addEventListener('submit', function(event) {
            var password = document.getElementById('password').value;
            var confirmPassword = document.getElementById('password_confirmation').value;

            if (password !== confirmPassword) {
                event.preventDefault();
                alert('Les mots de passe ne correspondent pas.');
            }
        });
    </script>
</body>

</html>
