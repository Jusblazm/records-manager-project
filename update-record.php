<?php // update-record.php
$pageTitle = "Update Record";
require_once 'inc/layout/header.inc.php';
?>

<div class="container">
    <div class="row mt-5">
        <div class="col-12 col-sm-12 col-md-6 col-lg-6">
            <div class="alert alert-info">
                <h1>Update Record</h1>
            </div>
            <?php require_once __DIR__ . '/inc/update/update.inc.php'; ?>
            <?php require_once __DIR__ . '/inc/shared/form.inc.php' ?>
        </div>
    </div>
</div>

<?php require_once 'inc/layout/footer.inc.php'; ?>