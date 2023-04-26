<?php
require_once '../config.php';
require_once 'parts/header.php';

$all_dir = scandir(ROOT_PATH . 'invoice/');

if (array_key_exists('page', $_GET)) {
    $page = $_GET['page'];
?>
    <main class="<?php echo $page; ?>">
        <?php
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
    </main>
<?php
}




require_once 'parts/footer.php';
