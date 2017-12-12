<?php include './config.php'; ?>
<?php include './classes/database.php'; ?>
<?php include './classes/quotes.php'; ?>
<?php 
  try {
    $quoteObj = new Quotes();
    $quote = $quoteObj->getSingle($_GET['id']);
  } catch (Throwable $e) {
    echo '<div class="alert alert-danger">'.get_class($e).' on line '.$e->getLine().' of '.$e->getFile().': '.$e->getMessage().'</div>';
  }

  if (isset($_POST['submit'])) {
    $id = $_GET['id'];
    $text = $_POST['text'] ?: null;
    $creator = $_POST['creator'] ?: 'Unknown';
    try {
      $quoteObj = new Quotes();
      $quoteObj->update($id, $text, $creator);
    } catch (Throwable $e) {
      echo '<div class="alert alert-danger">'.get_class($e).' on line '.$e->getLine().' of '.$e->getFile().': '.$e->getMessage().'</div>';
    }
  }

  if (isset($_POST['delete'])) {
    $id = $_GET['id'];
    try {
      $quoteObj = new Quotes();
      $quoteObj->remove($id);
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
          <h2 class="page-header">Edit Quote
            <form class="pull-right" action="edit.php?id=<?php echo $_GET['id']; ?>" method="POST">
              <button type="submit" name="delete" class="btn btn-danger">Delete</button>
            </form>
          </h2>
          <form action="edit.php?id=<?php echo $_GET['id']; ?>" method="POST">
            <div class="form-group">
              <label for="">Quote Text</label>
              <input type="text" class="form-control" name="text" value="<?php echo $quote['text'] ?>" placeholder="Quote text...">
            </div>
            <div class="form-group">
              <label for="">Creator / Author</label>
              <input type="text" class="form-control" name="creator" value="<?php echo $quote['creator'] ?>" placeholder="Quote creator...">
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