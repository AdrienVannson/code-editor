<?php
$couleurTheme = 'orange';
?>

<!DOCTYPE html>
<html>
<head>

<title>Code Editor</title>

<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link type="text/css" rel="stylesheet" href="static/materialize/css/materialize.min.css"  media="screen,projection"/>

<link rel="stylesheet" href="static/codemirror-5.34.0/lib/codemirror.css">
<link rel="stylesheet" href="static/codemirror-5.34.0/theme/dracula.css">

<meta name="viewport" content="width=device-width, initial-scale=1.0"/>

</head>

<body>


<!-- Barre de menu -->
<nav>
    <div class="nav-wrapper <?=$couleurTheme?>">
        <a href="#" class="brand-logo">Code Editor</a>
        <ul id="nav-mobile" class="right hide-on-med-and-down">
            <li><a href="#">New</a></li>
            <li><a href="#">Open</a></li>
        </ul>
    </div>
</nav>

<!-- Code editor -->
<textarea id="code-editor">
#include <iostream>

using namespace std;

int main ()
{
    return 0;
}
</textarea>


<script type="text/javascript" src="static/materialize/js/materialize.min.js"></script>

<script src="static/codemirror-5.34.0/lib/codemirror.js"></script>
<script src="static/codemirror-5.34.0/mode/clike/clike.js"></script>

<script>
    var editor = CodeMirror.fromTextArea(document.getElementById('code-editor'), {
        lineNumbers: true,
        theme: 'dracula',
        mode: "text/x-c++src"
    });
</script>

</body>
</html>