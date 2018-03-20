<?php

class Project
{
    function __construct ($path)
    {
        $this->path = $path;
    }

    function init ()
    {
        $this->delete();
        mkdir($this->path);
    }

    function delete ()
    {
        exec('rm -r ' . $this->path);
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
        file_put_contents($this->path.'/main.cpp', $code);
    }

    function setTest ($iTest, $contents)
    {
        file_put_contents($this->path.'/test'.$iTest, $contents);
    }

    private $path;
}