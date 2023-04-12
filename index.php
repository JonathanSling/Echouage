<?php
  spl_autoload_register(function($class) {
    include('class/'.$class.'.class.php');
  });

  function selected($value, $select = "")
  {
    if(isset($_SESSION[$value]) && $_SESSION[$value] == $select) echo "selected";
  }

  session_start();
  $echouageDb = new Database();

  $nbpage = 10;
  
  if(!(isset($_GET['page']) && $_GET['page'] > 0)){
    $_GET['page'] = 1;
  }

  if(!empty($_POST) && $_SESSION != $_POST ){
    $_SESSION = $_POST; 
    $_GET['page'] = 1;
  }

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Échouages</title>
  <link rel="icon" type="image/x-icon" href="assets/favicon.ico"><!-- Core theme CSS (includes Bootstrap)-->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link href="css/styles.css" rel="stylesheet">
  <script src="js/form.js" defer></script>
</head>

<body id="page-top">
  <!-- Navigation-->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top" id="mainNav">
    <div class="container px-4"><a class="navbar-brand" href="#page-top">ECHOUAGE</a><button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="/">Accueil</a></li>
          <li class="nav-item"><a class="nav-link" href="#echouage">Liste des échouages</a></li>
          <li class="nav-item"><a class="nav-link" href="statistiques.php">Statistiques</a></li>
          <li class="nav-item"><a class="nav-link" href="statistiques2.php">Statistiques 2</a></li>
        </ul>
      </div>
    </div>
  </nav><!-- Header-->
  <header class="bg-primary bg-gradient text-white">
    <div class="container px-4 text-center">
      <h1 class="fw-bolder">Echouage de cétacés</h1>
      <p class="lead">Lorem, ipsum dolor sit amet consectetur adipisicing elit. <br />At eaque maxime ratione perferendis hic totam modi.</p><a class="btn btn-lg btn-light" href="#echouage">Liste</a><a class="btn btn-lg btn-light mx-3" href="statistiques.php">Statistiques</a><a class="btn btn-lg btn-light" href="statistiques2.php">Statistiques 2</a>
    </div>
  </header>

  <section class="bg-light" id="echouage">
    <div class="container px-4">
      <div class="row gx-4 justify-content-center">
        <div class="col-lg-8">
          <h2>Liste échouages</h2>
          <p class="lead">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut optio velit inventore, expedita quo laboriosam possimus ea consequatur vitae, doloribus consequuntur ex. Nemo assumenda laborum vel, labore ut velit dignissimos.</p>

          <!-- Filtres -->
          <form class="d-flex align-items-center justify-content-between mb-3" method="post" action="">
            <select style="width: 8rem;" class="form-select ml-2" aria-label="date" name="date">
              <option <?php selected("date") ?> value="">Année</option>
              <?php 
                $results = $echouageDb->getDates();
                foreach($results as $value){?>
              <option value="<?php echo $value->getDate();?>" <?php selected("date", $value->getDate()) ?>><?php echo $value->getDate();?></option>
              <?php } ?>
            </select>

            <select style="width: 8rem; margin: 0 24px;" class="form-select" aria-label="espece" name="espece">
              <option <?php selected("espece") ?> value="">Espèce</option>
              <?php 
                $results = $echouageDb->getEspeces();
                foreach($results as $value){?>
              <option value="<?php echo $value->getEspece();?>" <?php selected("espece", $value->getEspece()) ?>><?php echo $value->getEspece();?></option>
              <?php } ?>
            </select>
            
            <select style="width: 8rem;" class="form-select" aria-label="zone" name="zone">
              <option <?php selected("zone") ?> value="">Zone</option>
              <?php 
                $results = $echouageDb->getZones();
                foreach($results as $value){?>
              <option value="<?php echo $value->getZone();?>" <?php selected("zone", $value->getZone()) ?>><?php echo $value->getZone();?></option>
              <?php } ?>
            </select>
            
            <input class="btn btn-primary ms-auto" type="submit" value="Filtrer">
          </form>

          <table class="table table-striped">
            <thead class="bg-primary text-white">
              <tr>
                <th scope="col" class="id">N°</th>
                <th scope="col" class="Date">Date</th>
                <th scope="col" class="label">Espece</th>
                <th scope="col" class="label">Zone</th>
                <th scope="col" class="label">Nombre</th>
                <th scope="col" class="label"></th>
              </tr>
            </thead>
            <tbody style="border: 1px solid black;">

                <?php
                  if(isset($_POST)){
                    $results = $echouageDb->getEchouages($_SESSION);
                  }else{
                    $results = $echouageDb->query("SELECT * FROM echouage LIMIT 10", "Echouage");
                  }

                  if(empty($results)){
                    echo '<td class="text-center" colspan="6">Pas de résultats</tr>';
                  }

                  foreach($results as $value){?>
                    <tr id="<?php echo $value->getId() ?>" class="click">
                      <td class="id"><?php echo $value->getId() ?></td>
                      <td class="id"><?php echo $value->getDate() ?></td>
                      <td class="label"><?php echo $value->getEspece() ?></td>
                      <td class="label"><?php echo $value->getZone() ?></td>
                      <td class="label"><?php echo $value->getNombre() ?></td>
                      <td class="label">                        
                        <button type="button" class="btn btn-primary">Modifier</button>
                      </td>
                    </tr>
                <?php
                  }
                ?>
              
                <!-- <tr style="border: 1px solid black;">
                  <td class="id">Ex ID</td>
                  <td class="id">Ex DATE</td>
                  <td class="label">Ex ESPECE</td>
                  <td class="label">Ex ZONE</td>
                  <td class="label">EX NBRE</td>
                </tr> -->
              
            </tbody>
          </table>

          <!-- Pagination -->
          <nav class="d-flex justify-content-center" aria-label="Page navigation example">
              <ul class="pagination">
                  <?php
                    $count = $echouageDb->getCountEchouages($_SESSION);
                    for($i = 1; $i <= $count; $i++){
                      if($i == 1 || $i == $count || ($i >= $_GET['page'] - 2 && $i <= $_GET['page'] + 2)){
                  ?>
                    <li class="page-item <?php if($i == $_GET['page']) echo "disabled" ?>"><a class="page-link" href="./?page=<?php echo $i ?>#echouage"><?php echo $i ?></a></li>
                  <?php
                      }else if($i == $_GET['page'] + 3 || $i == $_GET['page'] - 3){
                  ?>
                    <li class="page-item <?php if($i == $_GET['page']) echo "disabled" ?>"><a class="page-link">...</a></li>
                  <?php
                      }
                    }
                  ?>
              </ul>


              <!-- <select class="form-select ms-auto mb-3" style="width: fit-content;" aria-label="Default select example">
                <option>10</option>
                <option>20</option>
                <option>50</option>
              </select> -->
          </nav>
        </div>
      </div>
    </div>
  </section><!-- Contact section-->

  <div class="alert alert-success" role="alert">Cétacé n° modifié avec succès ! </div>
  
  <div class="alert alert-danger" role="alert"></div>
  <div class="form card px-5 py-3">
    <div id="close">&#x2715;</div>
    <h5 class="card-title my-3">modif cétacé n°</h5>
    <div class="d-flex align-items-center justify-content-center my-1">
      <div class="col-sm-4">
        <label for="date" class="form-label">Espèce</label>
      </div>
      <div class="col-sm-8">
        <input class="form-control" type="text" name="date">
      </div>
    </div>
    <div class="d-flex align-items-center justify-content-center my-1">
      <div class="col-sm-4">
        <label for="date" class="form-label">Année</label>
      </div>
      <div class="col-sm-8">
        <input class="form-control" type="text" name="date">
      </div>
    </div>
    <div class="d-flex align-items-center justify-content-center my-1">
      <div class="col-sm-4">
        <label for="nb" class="form-label">Nombre d'individus</label>
      </div>
      <div class="col-sm-8">
        <input class="form-control" type="text" name="nb">
      </div>
    </div><div class="d-flex align-items-center justify-content-center my-1">
      <div class="col-sm-4">
        <label for="zone" class="form-label">Zone</label>
      </div>
      <div class="col-sm-8">
        <input class="form-control" type="text" name="zone">
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
  <!-- <script src="js/scripts.js"></script> -->
</body>

</html>