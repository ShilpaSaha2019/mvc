<?php

class BaseController {
    protected function view(string $file, array $arguments=[]){
        extract($arguments);
        include "Views/{$file}.php";
    }
}