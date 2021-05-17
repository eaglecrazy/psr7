<?php

namespace Framework\Console;

class Output
{
    public function write(string $message){
        echo $message;
    }

    public function writeln(string $message){
        echo $message . PHP_EOL;
    }
}