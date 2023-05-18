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
    <link rel="shortcut icon" href="http://www.nuitsolutions.com/wp-content/uploads/2016/03/favicon-32x32.png">
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

<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light bg-dark">
        <div class="container">
              <a class="navbar-brand" href="/"><img src="https://www.nuitsolutions.com/wp-content/uploads/2022/03/NUIT-Logo-2.svg" alt="logo" width="200"></a>
              <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
              </button>
            
              <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                  <li class="nav-item">
                    <a class="nav-link text-white" href="<?php echo NAVIGATION_URL .'invoice-edit-clients' ?>">Add Client</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link text-white" href="<?php echo NAVIGATION_URL .'invoice-client-list' ?>">List Client</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link text-white" href="#">List Proforma</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link text-white" href="#">List Invoices</a>
                  </li>
                </ul>
              </div>
            </div>
        </nav>
    </header>