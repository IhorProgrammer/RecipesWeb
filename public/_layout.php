<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Сайт готовка</title>
    <link rel="icon" href="Image/Chef-logo.png" type="image/x-icon"/>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    
    
    <!-- Compiled and minified CSS -->
    <link rel="stylesheet" href="./lib/materialize.min.css">
    <!-- Compiled and minified JavaScript -->
    <script src="./lib/materialize.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="media-style.css">
</head>
<body>
    <header>
        <div class="container">
            <nav class="header-nav">
                <div class="brand-logo center">
                    <a href="/recipes"><img class="logo" src="Image/Chef-logo.png" alt="Logo-grill"></a>
                </div>
                <?php if (str_contains($page_body,"recipes") || (str_contains($page_body, "admin") && !str_contains($page_body, "admin_recipe"))): ?>
                  <div class="right">
                    <div class="input-field">
                      <i class="material-icons prefix">search</i>
                      <input id="search" placeholder="Пошук" type="text" class="validate">
                    </div>
                  </div>
                <?php endif ?>
            </nav>
            
        </div>
    </header>
    <hr>
    <main class="container row">        
        <?php include $page_body; ?>
    </main>
    <hr>
    <footer class="page-footer">
        <div class="container">
          <div class="row">
            <div class="col l6 s12">
              <h5>Кулінарний сайт</h5>
              <p>Цей сайт призначений для перегляду рецептів</p>
            </div>
            <div class="col l4 offset-l2 s12">
              <h5 >Категорії рецептів</h5>
              <ul>
                <li><a href="?tag=92,94,101,107">Що приготовити</a></li>
                <li><a href="?tag=105,167,156,143,145,154,162">Повсякденні рецепти</a></li>
                <li><a href="?tag=163,176,182,193,196">Рецепти на особливий випадок</a></li>
                <li><a href="?tag=199,205,210">На праздник</a></li>
                <li><a href="?tag=215,218,36,37,38">Кухня народів світу</a></li>
              </ul>
            </div>
          </div>
        </div>
        <div class="footer">
          <div class="container">
                Footer
          </div>
        </div>
      </footer>
</body>

<script src="script.js"></script>

</html>