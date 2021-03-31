<?php
    /** @var \Framework\Http\Template\PhpRenderer $this */
    $this->extend('layout/columns');
?>

<?php
    $this->params['title'] = 'About';
?>

<?php $this->beginBlock() ?>
<div class="panel panel-default">
    <div class="panel-heading">Cabinet</div>
    <div class="panel-body">
        About navigation
    </div>
</div>
<?php $this->endBlock('sidebar'); ?>

<ul class="breadcrumb">
    <li><a href="/">Home</a></li>
    <li class="active">Cabinet</li>
</ul>

<ul class="nav navbar-nav navbar-right">
    <li><a href="/about"><i class="glyphicon glyphicon-book"></i> About</a></li>
    <li><a href="/cabinet"><i class="glyphicon glyphicon-user"></i> Cabinet</a></li>
</ul>

<h1>About the site</h1>