<?php include './config.php'; ?>
<?php include './classes/database.php'; ?>
<?php include './classes/quotes.php'; ?>
<?php 
  try {
    $quoteObj = new Quotes();
    $quotes = $quoteObj->index();
  } catch (Throwable $e) {
    echo '<div class="alert alert-danger">'.get_class($e).' on line '.$e->getLine().' of '.$e->getFile().': '.$e->getMessage().'</div>';
  }
  
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Quotes</title>
	<link rel="stylesheet" href="./css/bootstrap.min.css">
	<link rel="stylesheet" href="./css/style.css">
</head>
<body>
	<div class="container">
      <div class="header clearfix">
        <nav>
          <ul class="nav nav-pills float-right">
            <li class="nav-item">
              <a class="nav-link active" href="index.php">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="new.php">New Quote</a>
            </li>
          </ul>
        </nav>
        <h3 class="text-muted">Quotes</h3>
      </div>

      <div class="jumbotron">
        <h1 class="display-3">Got A quote?</h1>
        <p class="lead">Store your favorite quotes here to access and read them daily and better your life</p>
        <p><a class="btn btn-lg btn-success" href="new.php" role="button">Add Quote Now</a></p>
      </div>

      <div class="row marketing">
        <div class="col-lg-12">
          <?php foreach ($quotes as $q): ?>
          <h3><a href="edit.php?id=<?php echo $q['id']; ?>"><?php echo $q['text'] ?></a></h3>
          <p><?php echo $q['creator'] ?></p>
          <?php endforeach ?>
        </div>

      </div>

      <footer class="footer">
        <p>© Quotes.Inc 2017</p>
      </footer>

    </div>
</body>
</html>