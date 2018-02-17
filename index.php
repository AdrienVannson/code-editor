<?php
include_once('model/projects.php');

$themeColor = 'blue-grey';
?>

<!DOCTYPE html>
<html>
<head>

<title>Code Editor</title>

<link type="text/css" rel="stylesheet" href="static/materialize/css/materialize.min.css" media="screen,projection"/>

<link rel="stylesheet" href="static/codemirror-5.34.0/lib/codemirror.css">
<link rel="stylesheet" href="static/codemirror-5.34.0/theme/dracula.css">

<link type="text/css" rel="stylesheet" href="styles.css"/>

<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

</head>

<body>


<!-- Toolbar -->
<nav>
    <div class="nav-wrapper <?=$themeColor?>">
        <a href="#" class="brand-logo">Code Editor</a>
        <ul id="nav-mobile" class="right hide-on-med-and-down">
            <li><a href="#">New</a></li>
            <li><a class="modal-trigger" href="#open-project">Open</a></li>
        </ul>
    </div>
</nav>


<!-- Code editor -->
<div id="code-editor-container">
<textarea id="code-editor">
#include <iostream>

using namespace std;

int main ()
{
    return 0;
}
</textarea>
</div>


<!-- FAB -->
<div class="fixed-action-btn">
    <a class="btn-floating btn-large waves-effect <?=$themeColor?>" onclick='run()'>
        <svg fill="#FFFFFF" height="32" viewBox="0 0 24 24" width="32" xmlns="http://www.w3.org/2000/svg" style="margin-top: 12px;">
            <path d="M0 0h24v24H0z" fill="none"/>
            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
        </svg>
    </a>
</div>


<!-- Open a project -->
<div class="modal" id="open-project">
    <div class="modal-content">
        <h2>Projects</h2>

        <?php
        foreach (getProjects() as $project) {
            ?>
            <a href="#"
               class="btn-flat waves-effect"
               onclick="openProject('<?= urlencode($project->getName()); ?>');">
                <?=$project->getName();?>
            </a><br/>
            <?php
        }
        ?>

    </div>
    <div class="modal-footer">
        <a href="#" class="modal-action modal-close waves-effect waves-red btn-flat">Close</a>
    </div>
</div>


<script type="text/javascript" src="static/materialize/js/materialize.min.js"></script>

<script src="static/codemirror-5.34.0/lib/codemirror.js"></script>
<script src="static/codemirror-5.34.0/mode/clike/clike.js"></script>
<script src="static/codemirror-5.34.0/addon/edit/closebrackets.js"></script>
<script src="static/codemirror-5.34.0/addon/edit/matchbrackets.js"></script>

<script src='script.js'></script>

</body>
</html>