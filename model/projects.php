<?php

include_once('Project.php');

function getProjects ()
{
    $projects = [];
    
    $projectsFolder = opendir(__DIR__.'/../projects/');

    while (($file = readdir($projectsFolder)) !== false) {
        if ($file != '.' && $file != '..') {
            $project = new Project(__DIR__.'/../projects/' . $file);
            array_push($projects, $project);
        }
    }

    return $projects;
}

function getProject ($name)
{
    return new Project(__DIR__.'/../projects/'.$name);
}
