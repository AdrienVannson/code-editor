<?php
include_once('../model/Project.php');

$name = $_GET['name'];
$path = '../projects/' . $name;

$project = new Project($path);

echo '{';

echo '"code": ' . json_encode($project->getCode());

echo '}';