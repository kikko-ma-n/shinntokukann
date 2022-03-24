<?php include __DIR__ . '/inc/header.php'; ?>

<!-- main -->
<main>
    <div id="main">
        <?php include __DIR__ . '/inc/checker.php' ?>
        <?php
            if(!empty($_POST['year'])) {
                include './inc/judged.php';
            }
        ?>

    </div>
    <?php include './inc/side.php'; ?>
</main>
<!-- main -->

<?php include __DIR__ . '/inc/footer.php';
