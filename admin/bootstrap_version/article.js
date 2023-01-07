function insertTextAtCursor(el, text, offset) {
    var val = el.value, endIndex, range, doc = el.ownerDocument;
    if (typeof el.selectionStart == "number"
            && typeof el.selectionEnd == "number") {
        endIndex = el.selectionEnd;
        el.value = val.slice(0, endIndex) + text + val.slice(endIndex);
        el.selectionStart = el.selectionEnd = endIndex + text.length+(offset?offset:0);
    } else if (doc.selection != "undefined" && doc.selection.createRange) {
        el.focus();
        range = doc.selection.createRange();
        range.collapse(false);
        range.text = text;
        range.select();
    }
}
function addBoldText() {
    insertTextAtCursor(document.querySelector('#articlePost'), '<b></b>');
}
function addUnderline() {
    insertTextAtCursor(document.querySelector('#articlePost'), '<u></u>');
}
function addItalic() {
    insertTextAtCursor(document.querySelector('#articlePost'), '<i></i>');
}
function addLink() {
    var link = prompt("Ссылка для вставки: ", "http://");
    insertTextAtCursor(document.querySelector('#articlePost'), '<a href="' + link + '"></a>');
}
function addH1() {
    insertTextAtCursor(document.querySelector('#articlePost'), '<h1></h1>');
}
function addH2() {
    insertTextAtCursor(document.querySelector('#articlePost'), '<h2></h2>');
}
function addH3() {
    insertTextAtCursor(document.querySelector('#articlePost'), '<h3></h3>');
}
function addRed() {
    insertTextAtCursor(document.querySelector('#articlePost'), '<font color="red"></font>');
}
function addBlue() {
    insertTextAtCursor(document.querySelector('#articlePost'), '<font color="blue"></font>');
}
function addGreen() {
    insertTextAtCursor(document.querySelector('#articlePost'), '<font color="green"></font>');
}
function addYellow() {
    insertTextAtCursor(document.querySelector('#articlePost'), '<font color="yellow"></font>');
}
function addLeft() {
    insertTextAtCursor(document.querySelector('#articlePost'), '<left></left>');
}
function addCenter() {
    insertTextAtCursor(document.querySelector('#articlePost'), '<center></center>');
}
function addRight() {
    insertTextAtCursor(document.querySelector('#articlePost'), '<p align="right"></p>');
}