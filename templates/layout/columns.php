<?php
/**
 * @var \Framework\Template\PhpRenderer $this
 */
?>

<?php
    /** @var string $content */
?>


<?php
    /** @var \Framework\Http\Template\PhpRenderer $this */
    $this->extend('layout/default');
?>

<div class="row">
    <div class="col-md-9">
        <?= $content ?>
    </div>
    <div class="col-md-3">
        <?= $this->blocks['sidebar'] ?>
    </div>
</div>