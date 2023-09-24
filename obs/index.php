<?php
  session_start();
  $count = 0;
  
  $title = "Home";
  require_once "./template/header.php";
  require_once "./functions/database_functions.php";
  $conn = db_connect();
  $row = select4LatestBook($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $title; ?></title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <style>

    .loading-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(255, 255, 255, 0.9); 
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 9999;
    }
    body {
    background-image: url('./download.jpg'); 
    background-size: cover;
    background-repeat: no-repeat;
    background-attachment: fixed; 
  }

    .loading-content {
      text-align: center;
      animation: fadeIn 2s linear; 
    }

    @keyframes fadeIn {
      0% { opacity: 0; }
      100% { opacity: 1; }
    }

    .spinning-book {
  width: 100px; 
  height: 100px;
}
    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
  </style>
</head>
<body>
  <div class="loading-overlay">
    <div class="loading-content">
      <h1>Namaste 🙏🙏🙏!</h1>
      <h1>Discover the World of Knowledge at Devrev Library</h1>
      <img src="loading.gif" alt="Spinning Book" class="spinning-book">
    </div>
  </div>

  <div class="container transparent-container">
    
    <div class="row mt-3">
      <div class="col-md-6 offset-md-3">
        <input type="text" id="searchInput" class="form-control" placeholder="Search for books...">
        <div id="suggestions"></div>
      </div>
    </div>

    <div class="lead text-center text-dark fw-bolder h4">Latest books</div>
    <center>
      <hr class="bg-warning" style="width:5em;height:3px;opacity:1">
    </center>
    <div class="row">
      <?php foreach($row as $book) { ?>
      <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 py-2 mb-2">
        <a href="book.php?bookisbn=<?php echo $book['book_isbn']; ?>" class="card rounded-0 shadow book-item text-reset text-decoration-none">
          <div class="img-holder overflow-hidden">
            <img class="img-top" src="./bootstrap/img/<?php echo $book['book_image']; ?>">
          </div>
          <div class="card-body">
            <div class="card-title fw-bolder h5 text-center"><?= $book['book_title'] ?></div>
          </div>
        </a>
      </div>
      <?php } ?>
    </div>
  </div>

  <?php
    if(isset($conn)) {mysqli_close($conn);}
    require_once "./template/footer.php";
  ?>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    setTimeout(function() {
      $(".loading-overlay").fadeOut("slow");
      $("body").css("overflow", "auto");
    }, 3000); 

    $(document).ready(function() {
      $("#searchInput").keyup(function() {
        var query = $(this).val();
        if (query != '') {
          $.ajax({
            url: "search.php",
            method: "POST",
            data: { query: query },
            success: function(data) {
              $("#suggestions").html(data);
              $("#suggestions").show(); 
            }
          });
        } else {
          $("#suggestions").html("").hide(); 
        }
      });
    });
  </script>
</body>
</html>
