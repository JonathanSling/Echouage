<?php
  spl_autoload_register(function($class) {
      include('class/'.$class.'.class.php');
  });

  function selected($value, $select = "")
  {
    if(isset($_GET[$value]) && $_GET[$value] == $select) echo "selected";
  }

  session_start();
  $echouageDb = new Database(1);

  if(!isset($_GET["date"]) || $_GET["date"] < 1949 || $_GET["date"] > date("Y")) $_GET = null;

  $result = $echouageDb->getStatistiques($_GET);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Échouages | Statistiques Annuelles</title>
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
      <h2>Statistiques Annuelles</h2>
      <p class="lead">Les statistiques suivantes sont filtrées par année</p>
    </div>
  </header>

  
  <section class="bg-light" id="echouage">
      <div class="container px-4">
          <div class="d-flex gx-4 justify-content-center">
              <div class="col-lg-8">
                  <div class="d-flex">
                      <div class="col-sm mx-1 my-2">
                  <form class="d-flex align-items-center justify-content-between mb-3" method="get" action="">
                    <select style="width: 8rem;" class="form-select ml-2" aria-label="date" name="date">
                        <option <?php selected("date") ?> value="">Année</option>
                        <?php 
                        $results = $echouageDb->getDates();
                        foreach($results as $value){?>
                        <option value="<?php echo $value->getDate();?>" <?php selected("date", $value->getDate()) ?>><?php echo $value->getDate();?></option>
                        <?php } ?>
                    </select>
                    
                    <input class="btn btn-primary ms-auto" type="submit" value="Filtrer">
                  </form> 
                <div class="card">
                  <div class="card-body fs-4">
                    <p class="card-text">Nombre total d'échouages enrengistrés : <span><?php echo $echouageDb->getCountEchouages($_GET)?></span></p>
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