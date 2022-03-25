window.onload = requestAuthorList;
window.onpopstate = popstateCallback;

function pushState(author_id, path) {
    console.log("before pushState()");
    console.log(history.state);
    window.history.pushState({'author_id' : author_id}, '', path);
    console.log("after pushState()");
    console.log(history.state);
}

function popState() {
    history.back();
}

function popstateCallback() {
    console.log("after popState");
    console.log(history.state);
    clearContent();
    if (history.state === null || history.state.author_id === null) {
        requestAuthorList();
    } else {
        requestBookList(history.state.author_id);
    }
}

function clearContent() {
    const container = document.querySelector('.container');
    while (container.firstChild) {
        container.removeChild(container.lastChild);
    }
}

function process404Response(response) {
    clearContent();
    generateHTML404();
}

function generateHTML404() {
    const container = document.querySelector('.container');

    const h1 = document.createElement('h1');
    h1.appendChild(document.createTextNode('Error 404 - Page not found!'));

    container.appendChild(h1);
}