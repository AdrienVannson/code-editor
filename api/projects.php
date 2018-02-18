<?php
// List all the projects

$projectsFolder = opendir('../projects/');

$projectsName = [];

while (($file = readdir($projectsFolder)) !== false) {

    if ($file != '.' && $file != '..') {
        array_push($projectsName, '"'.$file.'"');
    }
}
closedir($projectsFolder);

sort($projectsName, SORT_NATURAL);

echo '[' . join(',', $projectsName) . ']';