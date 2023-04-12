<?php
  spl_autoload_register(function($class) {
      include('class/'.$class.'.class.php');
  });

  $echouageDb = new Database();

  session_start();

  if(isset($_GET["id"]) && $_GET["id"] > 0){
      $id = (int) strip_tags($_GET['id']);
      $result = $echouageDb->getId($id);
  }

  include("description.php");

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Échouages | détails n°<?php echo $result->getId() ?></title>
  <link rel="icon" type="image/x-icon" href="assets/favicon.ico"><!-- Core theme CSS (includes Bootstrap)-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link href="css/styles.css" rel="stylesheet">
  <script src="js/form.js" defer></script>
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
      <h2><?php echo $result->getEspece(); ?></h2>
      <p class="lead"><?php echo getDescription($result->getEspece(), $typeEspece); ?></p>
    </div>
  </header>

  <section class="bg-light" id="echouage">
    <div class="container px-4">
      <div class="d-flex gx-4 justify-content-center">
        <div class="col-lg-8">

            <div class="d-flex">
              <div class="col-sm mx-1 my-2">
                <div class="card" style="height: 100%;">
                  <div class="card-header">
                    Informations cétacé n°<?php echo $result->getId() ?>
                  </div>
                  <div class="card-body fs-4">
                    <p class="card-text">Année : <?php echo $result->getDate() ?></p>
                    <p class="card-text">Nombre d'individus : <?php echo $result->getNombre() ?></p>
                    <p class="card-text">Zone : <?php echo $result->getZone() ?></p>
                    <button type="button" class="btn btn-primary edit-form" id="Modif-button">Modifier</button>
                  </div>
                </div>
              </div>
              <div class="col-sm mx-1 my-2">
                  <div id="map-container-google mt-2" class="img-thumbnail" style="width: 100%; height: 100%;">
                    <iframe frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://maps.google.com/maps?q=<?php echo $result->getZone() ?>&t=k&z=13&z=5&ie=UTF8&iwloc=&output=embed" frameborder="0" style="border:0; height: 100%; width: 100%;"></iframe>
                </div>
              </div>
            </div>
        </div>
      </div>
    </div>
  </section>

  <div class="alert alert-success" role="alert"><!-- Alerte de succes --></div>
  
  <!-- Formulaire de modification -->
  <div class="alert alert-danger" role="alert"></div>
  <div class="form card px-5 py-3">
    <div id="close">&#x2715;</div>
    <h5 class="card-title my-3">modif cétacé n°<?php echo $result->getId() ?></h5>
    <div class="d-flex align-items-center justify-content-center my-1">
      <div class="col-sm-4">
        <label for="date" class="form-label">Espèce</label>
      </div>
      <div class="col-sm-8">
        <input class="form-control" type="text" name="date" placeholder="<?php echo $result->getEspece() ?>">
      </div>
    </div>
    <div class="d-flex align-items-center justify-content-center my-1">
      <div class="col-sm-4">
        <label for="date" class="form-label">Année</label>
      </div>
      <div class="col-sm-8">
        <input class="form-control" type="text" name="date" placeholder="<?php echo $result->getDate() ?>">
      </div>
    </div>
    <div class="d-flex align-items-center justify-content-center my-1">
      <div class="col-sm-4">
        <label for="nb" class="form-label">Nombre d'individus</label>
      </div>
      <div class="col-sm-8">
        <input class="form-control" type="text" name="nb" placeholder="<?php echo $result->getNombre() ?>">
      </div>
    </div><div class="d-flex align-items-center justify-content-center my-1">
      <div class="col-sm-4">
        <label for="zone" class="form-label">Zone</label>
      </div>
      <div class="col-sm-8">
        <input class="form-control" type="text" name="zone" placeholder="<?php echo $result->getZone() ?>">
      </div>
    </div>
    <div class="mt-3 text-end">
      <button type="button" class="btn btn-primary float-right" id="confirm">Confirmer</button>
    </div>
  </div>

  
  <footer class="py-5 bg-dark">
    <div class="container px-4">
      <p class="m-0 text-center text-white">Copyright &copy; CIR2 2023</p>
    </div>
  </footer><!-- Bootstrap core JS-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script><!-- Core theme JS-->
</body>
</html>