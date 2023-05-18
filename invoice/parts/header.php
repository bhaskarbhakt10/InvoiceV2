<?php
//header file

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Invoice </title>
    <!-- //dependency  -->
    <?php
    $styles_dep = scandir(ROOT_PATH . 'assets/css/dependency-css');
    unset($styles_dep[0]);
    unset($styles_dep[1]);
    foreach ($styles_dep as $style_dep) {
    ?>
        <link rel="stylesheet" href="<?php echo ROOT_URL . 'assets/css/dependency-css/' . $style_dep ?>" />
    <?php
    }

    ?>

    <!-- // css  -->
    <?php
    $styles = scandir(ROOT_PATH . 'assets/css/custom-css');
    unset($styles[0]);
    unset($styles[1]);
    foreach ($styles as $style) {
    ?>
        <link rel="stylesheet" href="<?php echo ROOT_URL . 'assets/css/custom-css/' . $style ?>" />
    <?php
    }

    require_once ROOT_PATH_CLASS .'client/class.client.php';
    require_once ROOT_PATH_CLASS .'invoices/class.invoice.php';
    $client = new Client();
    $invoice = new Invoice();

    ?>
</head>
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
          <a class="navbar-brand" href="#">NUIT Invoice</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
        
          <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
              <li class="nav-item">
                <a class="nav-link" href="<?php echo NAVIGATION_URL .'invoice-edit-clients' ?>">Add Client</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?php echo NAVIGATION_URL .'invoice-client-list' ?>">List Client</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?php echo NAVIGATION_URL .'invoice-list-proforma' ?>">List Proforma</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?php echo NAVIGATION_URL .'invoice-clients' ?>">List Invoices</a>
              </li>
            </ul>
          </div>
        </div>
    </nav>
</header>

<body>