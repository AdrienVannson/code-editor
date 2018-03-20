// Confirmation on leaving
window.onbeforeunload = function() {
    return confirm();
};

function setProjectName (name)
{
    projectName = name;

    var title = 'Code Editor';
    if (name != '') {
        title += ' - ' + name;
    }

    document.title = title;
    document.getElementById('title').innerText = title;
}

function initProject ()
{
    setProjectName('');

    editor.getDoc().setValue('\
#include <iostream>\n\
\n\
using namespace std;\n\
\n\
int main ()\n\
{\n\
    return 0;\n\
}\n');
}

function runProg ()
{
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "api/run.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    var code = encodeURIComponent(editor.getValue());

    var toSend = 'code=' + code + '&nbTests=' + nbTests;

    for (var iTest=0; iTest<nbTests; iTest++) {
        toSend += '&input'+iTest+'=' + encodeURIComponent(document.getElementById('input'+iTest).value);
    }

    xhr.send(toSend);

    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
            M.toast({html: 'Done!'})

            res = JSON.parse(xhr.responseText);

            var compilationErrors = res.compilationErrors.replace(/\n/g, '<br/>').replace(/ /g, '&nbsp;');
            document.getElementById('compilation-errors').innerHTML = compilationErrors;

            for (var iTest=0; iTest<nbTests; iTest++) {
                document.getElementById('output'+iTest).innerHTML = res['output'+iTest];
                M.textareaAutoResize(document.getElementById('output'+iTest));
            }
        }
    };
}

function addTest ()
{
    document.getElementById('tests').innerHTML += ' \
        <div class="card"> \
            <div class="card-content row"> \
                <span class="card-title">Test '+nbTests+'</span> \
                <div class="input-field col s6"> \
                    <textarea id="input'+nbTests+'" class="materialize-textarea"></textarea> \
                    <label for="input'+nbTests+'">Input</label> \
                </div> \
                <div class="input-field col s6"> \
                    <textarea id="output'+nbTests+'" class="materialize-textarea"></textarea> \
                    <label for="output'+nbTests+'">Output</label> \
                </div> \
            </div> \
        </div>';

    nbTests++;
}

function openProject (name)
{
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "api/project.php?name="+name, true);
    xhr.send();

    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
            res = JSON.parse(xhr.responseText);
            editor.getDoc().setValue(res.code);

            M.Modal.getInstance( document.getElementById('open-project') ).close();

            setProjectName(decodeURI(name.replace(/\+/g, ' ')));
        }
    };
}

function saveProject ()
{
    if (projectName == '') {
        var name = prompt('Project name:');

        if (name === null) {
            name = '';
        }

        if (! /^\w+$/.test(name)) {
            M.toast({html: 'Error: invalid name'})
            return false;
        }

        setProjectName(name);
    }

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "api/saveProject.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    var name = encodeURIComponent(projectName);
    var code = encodeURIComponent(editor.getValue());

    var toSend = 'name='+name+'&code='+code+'&nbTests='+nbTests;

    for (var iTest=0; iTest<nbTests; iTest++) {
        toSend += '&test'+iTest+'=' + encodeURIComponent(document.getElementById('input'+iTest).value);
    }

    xhr.send(toSend);

    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
            M.toast({html: 'Project saved!'});
            updateProjects();
        }
    };
}

function updateProjects ()
{
    var projects = document.getElementById('projects');
    projects.innerHTML = '';

    var xhr = new XMLHttpRequest();
    xhr.open("GET", "api/projects.php");
    xhr.send();

    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
            res = JSON.parse(xhr.responseText);

            res.forEach(name => {
                projects.innerHTML += '<li class="collection-item"><div>\
                                            <a href="#" onclick="openProject(\''+name+'\');"> \
                                                '+name+' \
                                            </a>\
                                            <a href="#" onclick="deleteProject(\''+name+'\');" class="secondary-content">\
                                                <svg fill="#000000" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"/><path d="M0 0h24v24H0z" fill="none"/></svg> \
                                            </a>\
                                        </div></li>';
            });
        }
    };
}

function deleteProject (name)
{
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "api/deleteProject.php?name="+name);
    xhr.send();

    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
            updateProjects();
        }
    };
}


var projectName = '';
var nbTests = 0;

var editor = CodeMirror.fromTextArea(document.getElementById('code-editor'), {
    lineNumbers: true,
    indentUnit: 4,
    autoCloseBrackets: true,
    matchBrackets: true,
    theme: 'dracula',
    mode: "text/x-c++src"
});

M.Modal.init(document.getElementById('execution'), {});
M.Modal.init(document.getElementById('open-project'), {});

initProject();
updateProjects();
addTest();
