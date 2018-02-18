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
    var input = encodeURIComponent('42');

    xhr.send('code='+code+'&input='+input);

    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
            res = JSON.parse(xhr.responseText);

            var compilationErrors = res.compilationErrors.replace(/\n/g, '<br/>').replace(/ /g, '&nbsp;');
            document.getElementById('compilation-errors').innerHTML = compilationErrors;

            var output = res.output.replace(/\n/g, '<br/>').replace(/ /g, '&nbsp;');
            document.getElementById('output').innerHTML = output;
        }
    };
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
        }

        setProjectName(decodeURI(name.replace(/\+/g, ' ')));
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

    xhr.send('name='+name+'&code='+code);

    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
            M.toast({html: 'Project saved!'})
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
                projects.innerHTML += '<a href="#" \
                                          class="collection-item" \
                                          onclick="openProject(\''+name+'\');"> \
                                            '+name+' \
                                       </a>';
            });
        }

        setProjectName(decodeURI(name.replace(/\+/g, ' ')));
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
