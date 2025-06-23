<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Css/normalize.css">
    <link rel="stylesheet" href="Css/style.css">
    <title>hoofdpagina</title>
</head>
<body>
    <header>
        <!--Groene header voor elke pagina-->
        <a href="index.php">
            <img src="images/de-nerov2.png" alt="Website Mascotte" class="logo">
        </a>
        <h1>Pizza de Nero</h1>
        <a href="login.php">
            <img src="images/Profiel-pop.png" alt="Login icoon" class="login-icoon" title="Inloggen">
        </a>
        <a href="index.php" class="menu-knop" title="Pizza menu">
            <p>Menu</p>
        </a>
        <a href="winkelwagen.php">
            <img src="images/winkelkar.png" alt="Winkelkar icoon" class="winkelkar-icoon" title="Bekijk winkelwagen">
        </a>
    </header>

    <main>
        <!-- Sidebar -->
        <nav class="sidebar">
            <ul>
                <li><a href="#all">ALL</a></li>
                <li><a href="#vegan">Vegan</a></li>
                <li><a href="#vis">Vis</a></li>
                <li><a href="#vlees">Vlees</a></li>
            </ul>
        </nav>
    
        <!-- Pizza Secties -->
        <div class="pizza-secties"></div>

        <!-- Alle Pizzas Sectie -->
        <section>
            <div id="all" class="pizza-secties">
                <h2>Alle Pizzas</h2>
                <div class="pizza-grid">
                    <?php foreach ($allPizzas as $pizza): ?>
                    <div class="pizza-item">
                        <img src="<?php echo htmlspecialchars(getPizzaImage($pizza['name'])); ?>" 
                             alt="<?php echo htmlspecialchars($pizza['name']); ?>" 
                             class="pizza-afbeelding">
                        <h3><?php echo htmlspecialchars(cleanPizzaName($pizza['name'])); ?></h3>
                        <div class="prijs-info">
                            <span class="add-btn" onclick="addToCart('<?php echo htmlspecialchars($pizza['name']); ?>', <?php echo $pizza['price']; ?>)">+</span>
                            <span class="remove-btn" onclick="removeFromCart('<?php echo htmlspecialchars($pizza['name']); ?>')">-</span>
                            <span>€ <?php echo number_format($pizza['price'], 2, ',', '.'); ?></span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- Vega Pizzas Sectie -->
        <section>
            <div id="vegan" class="pizza-secties">
                <h2>Vega Pizzas</h2>
                <div class="pizza-grid">
                    <?php foreach ($vegaPizzas as $pizza): ?>
                    <div class="pizza-item">
                        <img src="<?php echo htmlspecialchars(getPizzaImage($pizza['name'])); ?>" 
                             alt="<?php echo htmlspecialchars($pizza['name']); ?>" 
                             class="pizza-afbeelding">
                        <h3><?php echo htmlspecialchars(cleanPizzaName($pizza['name'])); ?></h3>
                        <div class="prijs-info">
                            <span class="add-btn" onclick="addToCart('<?php echo htmlspecialchars($pizza['name']); ?>', <?php echo $pizza['price']; ?>)">+</span>
                            <span class="remove-btn" onclick="removeFromCart('<?php echo htmlspecialchars($pizza['name']); ?>')">-</span>
                            <span>€ <?php echo number_format($pizza['price'], 2, ',', '.'); ?></span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>

        <!-- Vis Pizzas Sectie -->
        <section>
            <div id="vis" class="pizza-secties">
                <h2>Vis Pizzas</h2>
                <div class="pizza-grid">
                    <!-- Voor nu geen vis pizza's in de database, maar je kunt ze later toevoegen -->
                    <div class="pizza-item">
                        <p>Binnenkort beschikbaar!</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Vlees Pizzas Sectie -->
        <section>
            <div id="vlees" class="pizza-secties">
                <h2>Vlees Pizzas</h2>
                <div class="pizza-grid">
                    <?php foreach ($vleesPizzas as $pizza): ?>
                    <div class="pizza-item">
                        <img src="<?php echo htmlspecialchars(getPizzaImage($pizza['name'])); ?>" 
                             alt="<?php echo htmlspecialchars($pizza['name']); ?>" 
                             class="pizza-afbeelding">
                        <h3><?php echo htmlspecialchars(cleanPizzaName($pizza['name'])); ?></h3>
                        <div class="prijs-info">
                            <span class="add-btn" onclick="addToCart('<?php echo htmlspecialchars($pizza['name']); ?>', <?php echo $pizza['price']; ?>)">+</span>
                            <span class="remove-btn" onclick="removeFromCart('<?php echo htmlspecialchars($pizza['name']); ?>')">-</span>
                            <span>€ <?php echo number_format($pizza['price'], 2, ',', '.'); ?></span>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    </main>
    
    <!--Footer voor elke pagina met de privacy verklaring-->
    <footer>
        <p>Reno Swart</p>
        <a href="privacy.php">Privacy verklaring</a>
    </footer>
</body>       
</html>