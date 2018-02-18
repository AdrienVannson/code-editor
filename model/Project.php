<?php

class Project
{
    function __construct ($path)
    {
        $this->path = $path;
    }

    function init ()
    {
        if (is_dir($this->path)) {
            exec('rm -r' . $this->path);
        }

        mkdir($this->path);
    }

    function getName ()
    {
        return basename($this->path);
    }

    function getCode ()
    {
        return file_get_contents($this->path . '/main.cpp');
    }

    function setCode ($code)
    {
        unlink($this->path);
        file_put_contents($this->path.'/main.cpp', $code);
    }

    private $path;
}