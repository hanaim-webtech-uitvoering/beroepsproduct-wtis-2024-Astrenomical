<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"  href="Css/normalize.css">
    <link rel="stylesheet" href="Css/style.css">
    <title>Wijzig bestellingen</title>
</head>
<body>
  <?php require_once 'header.php'; ?>
    <main>

    <!--Knoppen voor de bestel status-->
    <div class="wijziging-overzicht">
    <div class="bestel-info">
        <div class="bestel-numner">Bestelling #9876543</div>
        <div class="status-knoppen">
            <button class="status-knop grijs">In de oven</button>
            <button class="status-knop groen">Onderweg</button>
        </div>
    </div>

    <!--Adres overzicht van de bestelling-->
    <div class="adres-informatie">
        <p><strong>Straatnaam & Nummer:</strong> Van Vlietlaan 34</p>
        <p><strong>Postcode:</strong> 8891BC</p>
        <p><strong>Plaats:</strong> Arnhem</p>
    </div>

    <!--Overzicht van de bestelling-->
    <div class="wijziging-overzicht">
        <div class="wijziging-details">
            <h3>Bestelling overzicht</h3>
            <div>
                <p>Mozzarella pizza x2</p>
                <p>Pepperoni pizza x1</p>
            </div>
            <div class="wijziging-info">
                <div>17:54, 26-11-24</div>
                <div>€33.00</div>
            </div>
        </div>

        <!--Opmerkingen van de klant voor de bestelling-->
        <div class="opmerkingen-data">
            <p><strong>Opmerkingen:</strong></p>
            <textarea>Graag mijn telefoon nummer bellen, 06-1223334, mijn moeder slaapt</textarea>
         </div>
      </div>
  </div>
  </main>

  <!--Footer voor elke pagina met de privacy verklaring-->
  <footer>
    <p>Reno Swart</p>
    <a href="privacy.php">Privacy verklaring</a>
  </footer>  
</html>