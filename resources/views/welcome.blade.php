<html>

<head>
    <base href="https://api.univerdog.site/">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API UniversDog - Services Canins Complets</title>
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            line-height: 1.6;
            color: #333;
            background: linear-gradient(135deg, #f6d365 0%, #fda085 100%);
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        header {
            background-color: #ff6b6b;
            color: white;
            text-align: center;
            padding: 2rem 0;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        h1 {
            margin: 0;
            font-size: 2.5rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .api-description {
            background-color: white;
            border-radius: 12px;
            padding: 2rem;
            margin-top: 2rem;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        .services {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }

        .service {
            background-color: white;
            border-radius: 12px;
            padding: 1.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .service:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);
        }

        .service h3 {
            color: #ff6b6b;
            margin-top: 0;
        }

        .service-icon {
            font-size: 2rem;
            margin-bottom: 1rem;
        }

        footer {
            text-align: center;
            margin-top: 2rem;
            padding: 1rem;
            background-color: #ff6b6b;
            color: white;
        }

        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }

            h1 {
                font-size: 2rem;
            }
        }
    </style>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
</head>

<body>
    <header>
        <h1>API UniversDog</h1>
        <p>La plateforme complète pour les propriétaires de chiens et les professionnels canins</p>
    </header>

    <div class="container">
        <div class="api-description">
            <h2>Bienvenue sur l'API UniversDog</h2>
            <p>Notre API, accessible uniquement via univerdog.site, offre une plateforme complète pour les propriétaires
                de chiens et les professionnels du secteur canin. Nous fournissons une multitude de services pour
                améliorer la vie des chiens et de leurs maîtres.</p>
        </div>

        <div class="services">
            <div class="service">
                <div class="service-icon">💇</div>
                <h3>Toilettage et Coiffure</h3>
                <p>Trouvez les meilleurs salons de toilettage pour votre compagnon.</p>
            </div>

            <div class="service">
                <div class="service-icon">🛒</div>
                <h3>Vente de Produits</h3>
                <p>Accédez à une large gamme de produits pour chiens.</p>
            </div>

            <div class="service">
                <div class="service-icon">🏥</div>
                <h3>Services Vétérinaires</h3>
                <p>Connectez-vous avec des vétérinaires qualifiés.</p>
            </div>

            <div class="service">
                <div class="service-icon">🗺️</div>
                <h3>Localisation de Services</h3>
                <p>Trouvez facilement les services canins près de chez vous.</p>
            </div>

            <div class="service">
                <div class="service-icon">🎓</div>
                <h3>Formation et Éducation</h3>
                <p>Accédez à des ressources pour l'éducation de votre chien.</p>
            </div>

            <div class="service">
                <div class="service-icon">🏠</div>
                <h3>Service de Garde</h3>
                <p>Trouvez des gardiens fiables pour votre chien.</p>
            </div>

            <div class="service">
                <div class="service-icon">📄</div>
                <h3>Aide Administrative</h3>
                <p>Obtenez de l'aide pour les démarches administratives liées à votre chien.</p>
            </div>

            <div class="service">
                <div class="service-icon">✈️</div>
                <h3>Voyages pour Chiens</h3>
                <p>Planifiez des voyages adaptés à votre compagnon.</p>
            </div>

            <div class="service">
                <div class="service-icon">🤖</div>
                <h3>Conseils IA pour Chiens</h3>
                <p>Bénéficiez de conseils personnalisés grâce à l'intelligence artificielle.</p>
            </div>
        </div>
    </div>

    <footer>
        <p>&copy; 2024 UniversDog API. Tous droits réservés.</p>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const services = document.querySelectorAll('.service');

            services.forEach(service => {
                service.addEventListener('click', () => {
                    const serviceName = service.querySelector('h3').textContent;
                    alert(
                        `Vous avez sélectionné le service : ${serviceName}\nPour plus d'informations sur l'utilisation de ce service via notre API, veuillez consulter notre documentation complète sur univerdog.site.`);
                });
            });
        });
    </script>
</body>

</html>
