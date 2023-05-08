<?php
require_once '../config.php';
require_once 'parts/header.php';

$all_dir = scandir(ROOT_PATH . 'invoice/');
?>
<main >
    <div class="container-fluid">
        <?php
        if (array_key_exists('page', $_GET)) {
        ?>
            <div class="<?php echo $page; ?>">
                <?php
                $page = $_GET['page'];
                if (in_array($page  . ".php", $all_dir)) {
                    foreach ($all_dir as $d) {
                        if ($d === $page  . ".php") {
                            require_once ROOT_PATH . 'invoice/' . $page  . ".php";
                        }
                    }
                } else {
                    echo "no file";
                }
                ?>
            </div>
        <?php
        }
        ?>
        <!-- //index page start  -->
        <div class="index-wrapper">
            <div class="row">
                <div class="col-md-12">
                    <div>
                        <button class="btn"></button>
                    </div>
                </div>
            </div>
        </div>
        <!-- //index page end  -->
    </div>
</main>


<?php
require_once 'parts/footer.php';
