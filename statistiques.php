<?php
  spl_autoload_register(function($class) {
      include('class/'.$class.'.class.php');
  });

  $echouageDb = new Database(1);

  $result = $echouageDb->getStatistiques();

  session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Échouages | Statistiques Générales</title>
  <link rel="icon" type="image/x-icon" href="assets/favicon.ico"><!-- Core theme CSS (includes Bootstrap)-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link href="css/styles.css" rel="stylesheet">
  <!-- <script src="js/form.js" defer></script> -->
</head>

<body id="page-top">
  <!-- Navigation-->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <div class="container px-4"><a class="navbar-brand" href="index.php">ECHOUAGE</a><button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="index.php">Accueil</a></li>
          <li class="nav-item"><a class="nav-link" href="index.php#echouage">Liste des échouages</a></li>
          <li class="nav-item"><a class="nav-link" href="statistiques.php">Statistiques</a></li>
          <li class="nav-item"><a class="nav-link" href="statistiques2.php">Statistiques 2</a></li>
        </ul>
      </div>
    </div>
  </nav><!-- Header-->

  <header class="bg-primary bg-gradient text-white">
    <div class="container px-4 text-center">      
      <h2>Statistiques Générales</h2>
      <p class="lead">Les statistiques suivantes sont pour toutes dates confondues</p>
    </div>
  </header>

  <section class="bg-light" id="echouage">
    <div class="container px-4">
      <div class="d-flex gx-4 justify-content-center">
        <div class="col-lg-8">
            <div class="d-flex">
              <div class="col-sm mx-1 my-2">
                <div class="card" style="height: 100%;">
                  <div class="card-body fs-4">
                    <p class="card-text">Nombre total d'échouages enrengistrés : <span><?php echo $echouageDb->getCountEchouages()?></span></p>
                    <p class="card-text">Individus le plus touché : <span><?php echo $result["espece"][0]->getValeur()."</span> (".$result["espece"][0]->getTotal().")" ?></p>
                    <p class="card-text">Zone d'échouage la plus courante : <span><?php echo $result["zone"][0]->getValeur()."</span> (".$result["zone"][0]->getTotal().")" ?></p>
                  </div>
                </div>
              </div>
            </div>
        </div>
      </div>
    </div>
  </section>

  
  <footer class="py-5 bg-dark">
    <div class="container px-4">
      <p class="m-0 text-center text-white">Copyright &copy; CIR2 2023</p>
    </div>
  </footer><!-- Bootstrap core JS-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script><!-- Core theme JS-->
</body>
</html>