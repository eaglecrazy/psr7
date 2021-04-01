<?php
/** @var \Framework\Http\Template\PhpRenderer $this */
?>

<?php
    /** @var string $content */
?>


<?php
    /** @var \Framework\Http\Template\PhpRenderer $this */
    $this->extend('layout/default');
?>

<?= $this->beginBlock('content') ?>
    <div class="row">
        <div class="col-md-9">
            <?= $this->renderBlock('main') ?>
        </div>
        <div class="col-md-3">
            <?= $this->renderBlock('sidebar') ?>
        </div>
    </div>
<?= $this->endBlock() ?>
