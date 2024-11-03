<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificat de Produit</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f1f1f1; /* Couleur de fond douce */
        }
        .container {
            max-width: 850px;
            margin: 50px auto;
            border: 2px solid #D4AF37;
            border-radius: 15px;
            background-color: #ffffff;
            position: relative;
            overflow: hidden;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15); /* Ombre plus marquée */
        }
        .background-logo {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 1;
            opacity: 0.03; /* Logo de fond plus subtil */
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 200px; /* Taille ajustée pour remplir l'espace */
            color: #D4AF37; /* Couleur dorée pour harmonie */
        }
        .header {
            padding: 60px 40px;
            position: relative;
            z-index: 2;
            text-align: center;
        }
        .header h1 {
            color: #333;
            font-weight: bold;
            font-size: 2.8em; /* Taille augmentée */
            margin-bottom: 20px;
        }
        .header h3 {
            color: #007bff;
            font-weight: bold;
            font-size: 1.8em;
            margin-bottom: 15px;
        }
        .header p {
            color: #555;
            font-size: 1.2em;
            margin: 5px 0;
        }
        .badge {
            background-color: #FFD700;
            color: #333;
            padding: 5px 15px;
            border-radius: 10px;
            font-weight: bold;
            display: inline-block;
            margin-top: 10px;
        }
        .signature {
            padding: 30px;
            text-align: right; /* Alignement à droite */
            margin-top: 40px;
            border-top: 2px solid #D4AF37;
        }
        .signature p {
            font-style: italic;
            margin-bottom: 5px;
            color: #555;
        }
        .signature img {
            width: 160px;
            height: auto;
            display: inline-block;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Logo en fond -->
        <div class="background-logo">
            Res<span class="text-secondary">cueF</span>ood
        </div>

        <div class="header">
            <h1>Certificat de Produit</h1>
            <i class="fas fa-award fa-3x text-warning mb-4"></i>
            <hr style="border-top: 2px solid #D4AF37; width: 50%; margin: 20px auto;">
            
            <h3>{{ $certification->nom }}</h3>
            <p>Description : {{ $certification->description }}</p>
            <div class="badge">Date : {{ \Carbon\Carbon::parse($certification->date_validation)->format('d M Y') }}</div>
        </div>

        <div class="signature">
            <p>Responsable de la certification</p>
            <img src="{{ asset('img/fake_signature.png') }}" alt="Signature">
        </div>
    </div>
</body>
</html>
