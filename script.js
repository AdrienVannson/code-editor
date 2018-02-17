var editor = CodeMirror.fromTextArea(document.getElementById('code-editor'), {
    lineNumbers: true,
    indentUnit: 4,
    autoCloseBrackets: true,
    matchBrackets: true,
    theme: 'dracula',
    mode: "text/x-c++src"
});

M.Modal.init(document.querySelector('.modal'), {});


function run ()
{
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "api/run.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    var code = encodeURIComponent(editor.getValue());
    var input = encodeURIComponent('42');

    xhr.send('code='+code+'&input='+input);

    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && (xhr.status == 200 || xhr.status == 0)) {
            alert(xhr.responseText);
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
    };
}
