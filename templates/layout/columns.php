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

<?php $this->beginBlock('content') ?>
    <div class="row">
        <div class="col-md-9">
            <?= $this->renderBlock('main') ?>
        </div>

        <?php if($this->ensureBlock('sidebar')) : ?>
        <div class="panel panel-default">
            <div class="panel-heading">Site</div>
            <div class="panel-body">
                Site navigation
            </div>
        </div>
        <?php $this->endBlock(); endif; ?>

        <div class="col-md-3">
            <?= $this->renderBlock('sidebar') ?>
        </div>
    </div>
<?php $this->endBlock() ?>
