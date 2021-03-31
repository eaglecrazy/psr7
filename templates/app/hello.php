<?php
    /** @var \Framework\Http\Template\PhpRenderer $this */
    $this->extend('layout/default');
?>

<?php
    $this->params['title'] = 'Hello';
?>
<div class="jumbotron">
    <h1>Hello!</h1>
    <p>
        Congratulations! You have successfully created your application.
    </p>
</div>
