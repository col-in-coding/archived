<?php include './config.php'; ?>
<?php include './classes/database.php'; ?>
<?php include './classes/quotes.php'; ?>
<?php 
  if (isset($_POST['submit'])) {
    $text = $_POST['text'] ?: null;
    $creator = $_POST['creator'] ?: 'Unknown';
    try {
      $quoteObj = new Quotes();
      $quotes = $quoteObj->add($text, $creator);
    } catch (Throwable $e) {
      echo '<div class="alert alert-danger">'.get_class($e).' on line '.$e->getLine().' of '.$e->getFile().': '.$e->getMessage().'</div>';
    }
  }

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Quotes | New Quote</title>
	<link rel="stylesheet" href="./css/bootstrap.min.css">
	<link rel="stylesheet" href="./css/style.css">
</head>
<body>
	<div class="container">
      <div class="header clearfix">
        <nav>
          <ul class="nav nav-pills float-right">
            <li class="nav-item">
              <a class="nav-link" href="index.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" href="new.php">New Quote <span class="sr-only">(current)</span></a>
            </li>
          </ul>
        </nav>
        <h3 class="text-muted">Quotes</h3>
      </div>

      <div class="row marketing">
        <div class="col-lg-12">
          <h2 class="page-header">Add New Quote</h2>  
          <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <div class="form-group">
              <label for="">Quote Text</label>
              <input type="text" class="form-control" name="text" placeholder="Quote text...">
            </div>
            <div class="form-group">
              <label for="">Creator / Author</label>
              <input type="text" class="form-control" name="creator" placeholder="Quote creator...">
            </div>
            <button type="submit" name="submit" class="btn btn-default">Submit</button>
          </form>
        </div>

      </div>

      <footer class="footer">
        <p>© Quotes.Inc 2017</p>
      </footer>

    </div>
</body>
</html>