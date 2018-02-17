<?php

class Project
{
    function __construct ($path)
    {
        $this->path = $path;
    }

    function getName ()
    {
        return basename($this->path);
    }

    function getCode ()
    {
        return file_get_contents($this->path . '/main.cpp');
    }

    private $path;
}