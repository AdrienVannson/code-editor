<?php
include_once('model/projects.php');

$themeColor = 'blue-grey';
?>

<!DOCTYPE html>
<html>
<head>

<title></title>

<link type="text/css" rel="stylesheet" href="static/materialize/css/materialize.min.css"/>

<link rel="stylesheet" href="static/codemirror-5.34.0/lib/codemirror.css">
<link rel="stylesheet" href="static/codemirror-5.34.0/theme/dracula.css">

<link type="text/css" rel="stylesheet" href="styles.css"/>

<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

</head>

<body>


<!-- Toolbar -->
<nav>
    <div class="nav-wrapper <?=$themeColor?>">
        <span class="brand-logo" id="title"></span>
        <a href="#" data-target="mobile-demo" class="sidenav-trigger">Menu</a>
        <ul id="nav-mobile" class="right hide-on-med-and-down">
            <li><a href="#" onclick="initProject();">New</a></li>
            <li><a class="modal-trigger" href="#open-project">Open</a></li>
            <li><a href="#" onclick="saveProject();">Save</a></li>
            <li><a class="modal-trigger" href="#about">About</a></li>
        </ul>
    </div>
</nav>

<ul class="sidenav" id="mobile-demo">
    <li><a href="#" onclick="initProject();">New</a></li>
    <li><a class="modal-trigger" href="#open-project">Open</a></li>
    <li><a href="#" onclick="saveProject();">Save</a></li>
    <li><a class="modal-trigger" href="#about">About</a></li>
</ul>


<!-- Code editor -->
<textarea id="code-editor"></textarea>


<!-- FAB -->
<div class="fixed-action-btn">
    <a class="btn-floating btn-large waves-effect <?=$themeColor?> modal-trigger" href="#execution">
        <svg fill="#FFFFFF" height="32" viewBox="0 0 24 24" width="32" xmlns="http://www.w3.org/2000/svg" style="margin-top: 12px;">
            <path d="M0 0h24v24H0z" fill="none"/>
            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
        </svg>
    </a>
</div>


<!-- Tests -->
<div class="modal" id="execution">
    <div class="modal-content">
        <h2>Tests</h2>

        Compilation errors:
        <div class="card-panel" id="compilation-errors"></div>

        <div id="tests"></div>

        <a class="btn-floating btn-large green waves-effect" onclick="addTest();">
            <svg fill="#FFFFFF" height="32" width="32" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="margin-top: 12px;">
                <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/>
                <path d="M0 0h24v24H0z" fill="none"/>
            </svg>
        </a>

        <a href="#" class="btn waves-effect green" onclick="runProg()">Go !</a>

    </div>
    <div class="modal-footer">
        <a href="#" class="modal-action modal-close waves-effect waves-red btn-flat">Close</a>
    </div>
</div>


<!-- Open a project -->
<div class="modal" id="open-project">
    <div class="modal-content">
        <h2>Projects</h2>
        <ul id="projects" class="collection"></ul>
    </div>
    <div class="modal-footer">
        <a href="#" class="modal-action modal-close waves-effect waves-red btn-flat">Close</a>
    </div>
</div>


<!-- About -->
<div class="modal" id="about">
    <div class="modal-content">
        <h2>About code-editor</h2>
        <p>Developed by Adrien VANNSON</p>
        <p>Contact: <a href="mailto:adrien.vannson@gmail.com">adrien.vannson@gmail.com</a>
    </div>
    <div class="modal-footer">
        <a href="#" class="modal-action modal-close waves-effect waves-red btn-flat">Close</a>
    </div>
</div>


<script src="static/materialize/js/materialize.min.js"></script>

<script src="static/codemirror-5.34.0/lib/codemirror.js"></script>
<script src="static/codemirror-5.34.0/mode/clike/clike.js"></script>
<script src="static/codemirror-5.34.0/addon/edit/closebrackets.js"></script>
<script src="static/codemirror-5.34.0/addon/edit/matchbrackets.js"></script>

<script src='script.js'></script>

</body>
</html>
