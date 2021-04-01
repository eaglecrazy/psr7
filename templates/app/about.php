<?php
    /** @var \Framework\Http\Template\PhpRenderer $this */
    $this->extend('layout/columns');
?>

<?php $this->beginBlock('title') ?>
    About
<?php $this->endBlock(); ?>

<?php $this->beginBlock('breadcrumbs') ?>
    <ul class="breadcrumb">
        <li><a href="/">Home</a></li>
        <li class="active">About</li>
    </ul>
<?php $this->endBlock(); ?>

<?php $this->beginBlock('main') ?>
    <h1>About the site</h1>
<?php $this->endBlock(); ?>

