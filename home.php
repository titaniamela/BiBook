<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <title>BiBook</title>
</head>

<body>
  <head>
    <div class="container">
      <nav class="navbar navbar-expand-lg navbar-light ">
        <a class="navbar-brand" href="home.php">BiBook</a>
        </button>
      </nav>
    </div>
  </head>
  <?php
  require_once("sparqllib.php");
  $test = "";
  if (isset($_POST['search-bibook'])) {
    $test = $_POST['search-bibook'];
    $data = sparql_get(
      "localhost:3030/book",
      "
        PREFIX p: <http://BiBook.com>
        PREFIX d: <http://BiBook.com/ns/data#>
        
        SELECT ?Nama ?Tipe ?Sinopsis ?Rilis ?Penulis ?JumlahHlmn
        WHERE
        { 
            ?s  d:nama ?Nama;
                d:isbn ?ISBN;
                d:jenis ?Tipe;
                d:sinopsis ?Sinopsis;
                d:tanggalTerbit ?Rilis;
                d:author ?Penulis;
                d:jumlahHalaman ?JumlahHlmn
                FILTER (regex(?Nama, '$test', 'i') || regex(?Penulis,  '$test', 'i') || regex(?Tipe,  '$test', 'i'))
    
        }
            "
    );
  } else {
    $data = sparql_get(
      "localhost:3030/book",
      "
        PREFIX p: <http://BiBook.com>
        PREFIX d: <http://BiBook.com/ns/data#>
        
        SELECT ?Nama ?Tipe ?Sinopsis ?Rilis ?Penulis ?JumlahHlmn
        WHERE
        { 
            ?s  d:nama ?Nama;
                d:isbn ?ISBN;
                d:jenis ?Tipe;
                d:sinopsis ?Sinopsis;
                d:tanggalTerbit ?Rilis;
                d:author ?Penulis;
                d:jumlahHalaman ?JumlahHlmn
    
        } LIMIT 4
            "
    );
  }

  if (!isset($data)) {
    print "<p>Error: " . sparql_errno() . ": " . sparql_error() . "</p>";
  }

  //var_dump($test);
  // $search = $_POST['search-bibook'];
  //         var_dump($search);
  ?>

  <div class="main">
    <div class="container">
      <div class="shadow mb-5 bg-white rounded layout">
        <div class="form-group has-search">
          <form action="" method="post" id="nameform">
            <div class="input-group">
              <span class="fa fa-search fa-1x form-control-feedback"></span>
              <input type="text" name="search-bibook" class="form-control form-control-lg " placeholder="Masukan Judul Buku, Jenis Buku atau Penulis">
              <div class="input-group-append">
                <button class="btn btn-secondary" type="submit"> Search
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <div class="konten">
    <div class="container">
      <h3>Search Result</h3>
      <p>Search: <span>
          <?php
          if ($test != NULL) {
            echo $test;
          } else {
            echo "Search Keyword";
          }
          ?></span></p>
      <hr>
      <div class="row">
        <?php foreach ($data as $dat) : ?>
          <div class="col-lg-6">
            <div class="card">
              <div class="card-body">
                <div class="card-title">
                  <div class="header-data"> <b>Judul : </b></div>
                  <div class="item-data" id="nama-db"><b><?= $dat['Nama'] ?></b></div>
                  <div class="accordion" id="accordionExample">
                    <div class="card">
                      <div class="card-header" id="headingOne">
                        <h2 class="mb-0">
                            Sinopsis
                        </h2>
                      </div>
                        <div class="card-body">
                          <?= $dat['Sinopsis'] ?>
                        </div>
                      </div>
                  </div>
                  <hr>
                </div>
              </div>
              <ul class="list-group list-group-flush">
                <li class="list-group-item">
                  <div class="header-data"> <b>Jenis :</b>
                    <div class="item-data"><?= $dat['Tipe'] ?></div>
                  </div>
                </li>
                <li class="list-group-item">
                  <div class="header-data"> <b>Rilis :</b></div>
                  <div class="item-data"><?= $dat['Rilis'] ?></div>
                </li>
                <li class="list-group-item">
                  <div class="header-data"> <b>Penulis :</b></div>
                  <div class="item-data"><?= $dat['Penulis'] ?></div>
                </li>
                <li class="list-group-item">
                  <div class="header-data"> <b>Banyak Halaman :</b></div>
                  <div class="item-data"><?= $dat['JumlahHlmn'] ?></div>
                </li>
              </ul>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</body>

<style>
  body {
    background-image: url("asset/3.jpg");
    background-size: cover;
    font-family: 'Poppins', sans-serif;
    font-weight: 400;
    color: #f36b3a;
  }
  .navbar-brand span {
  font-style: normal;
  font-weight: bold;
  font-size: 30px;
  color: #FFFFFF;
}
  .has-search .form-control {
    padding-left: 2.375rem;
  }

  .has-search .form-control-feedback {
    position: absolute;
    z-index: 2;
    display: block;
    width: 2.375rem;
    height: 2.375rem;
    line-height: 2.375rem;
    text-align: center;
    pointer-events: none;
    color: #f36b3a;
    margin-top: 5px
  }

  .form-control {
    background-color: #fff;
    border: 0;
  }

  .layout {
    margin-top: -60px;
  }

  .header-data {
    padding-right: 15px;
    justify-content: space-between;
    font-weight: 500;
    letter-spacing: 2%;
  }

  .item-data {
    padding-right: 15px;
    justify-content: space-between;
    font-weight: 400;
    letter-spacing: 2%;
  }

  .data {
    line-height: 30px;
    padding-bottom: 10px;
  }

  .card {
    margin-bottom: 40px;
    border-radius: 10px;
  }
</style>
</body>
</html>