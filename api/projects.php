<?php
// List all the projects

$projectsFolder = opendir('../projects/');

echo '[';

$isFirst = true;

while (($file = readdir($projectsFolder)) !== false) {

    if (!$isFirst) {
        echo ',';
    }

    if ($file != '.' && $file != '..') {
        echo '"' . $file . '"';
        $isFirst = false;
    }
}
closedir($projectsFolder);

echo ']';