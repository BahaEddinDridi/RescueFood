<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificat de Produit</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }
        .container {
            max-width: 800px;
            margin: 50px auto; /* Add some space from top */
            border: 2px solid #D4AF37;
            border-radius: 10px;
            background-color: #ffffff; /* Change background to white for contrast */
            position: relative;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2); /* Increased shadow for depth */
        }
        .background-logo {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 1;
            opacity: 0.05; /* Lighter logo for subtlety */
            display: flex;
            justify-content: center;
            align-items: center;
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
            font-size: 2.5em; /* Increased size for the title */
            margin-bottom: 20px;
        }
        .header h3 {
            color: #007bff;
            font-weight: bold;
            margin-bottom: 15px; /* Added margin for spacing */
        }
        .header p {
            color: #555;
            font-size: 1.2em;
            margin: 5px 0; /* Added margin for spacing */
        }
        .badge {
            background-color: gold;
            color: black;
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: bold;
        }
        .signature {
            padding: 20px;
            text-align: left;
            margin-top: 40px; /* Added margin for spacing */
            border-top: 2px solid #D4AF37; /* Added border to separate signature */
        }
        .signature p {
            font-style: italic;
            margin-bottom: 5px;
        }
        .signature img {
            width: 150px;
            height: auto;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Background Logo -->
        <div class="background-logo center">
            <h1 class="fw-bold text-primary m-0" style="font-size: 100px;">Res<span class="text-secondary">cueF</span>ood</h1>
        </div>

        <div class="header">
            <h1 class="display-4 mb-4">Certificat de Produit</h1>
            <i class="fas fa-award fa-3x text-warning mb-4"></i> <!-- Badge Icon -->
            <hr class="my-4" style="border-top: 2px solid #D4AF37; width: 50%; margin: auto;">
            
            <h3>{{ $certification->nom }}</h3>
            <p>Description : {{ $certification->description }}</p>
            
        </div>

        <div class="signature">
            <p>Signature :</p>
            <img src="{{ asset('img/fake_signature.png') }}" alt="Signature">
        </div>
    </div>
</body>
</html>
