<?php
// footer file 

?>
<footer>

    <script src="<?php echo ROOT_URL ;?>assets/js/dependency-js/jquery.script.jQuery.js"></script>
    <script src="<?php echo ROOT_URL ;?>assets/js/dependency-js/script.bootstrap.js"></script>
    <script src="<?php echo ROOT_URL ;?>assets/js/dependency-js/script.material-bootstrap.js"></script>
    <script src="<?php echo ROOT_URL ;?>assets/js/dependency-js/script.datatables.js"></script>
    <script src="<?php echo ROOT_URL ;?>assets/js/dependency-js/script.datatables.responsive.js"></script>
    <script src="<?php echo ROOT_URL ;?>assets/js/dependency-js/script.select2.min.js"></script>
    <script src="<?php echo ROOT_URL ;?>assets/js/dependency-js/html2canvas.js"></script>
    <script src="<?php echo ROOT_URL ;?>assets/js/dependency-js/jspdf.js"></script>

    <?php
    $scripts = scandir(ROOT_PATH . 'assets/js/custom-scripts');
    unset($scripts[0]);
    unset($scripts[1]);
    foreach ($scripts as $script) {
    ?>
        <script src="<?php echo ROOT_URL . 'assets/js/custom-scripts/' . $script ?>"></script>
    <?php
    }
    ?>
</footer>
</body>

</html>