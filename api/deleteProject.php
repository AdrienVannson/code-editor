<?php
// Delete a project

include_once('../model/projects.php');

$name = $_GET['name'];

$project = getProject($name);
$project->delete();
