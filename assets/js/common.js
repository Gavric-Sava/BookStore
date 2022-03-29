window.onload = requestAuthorList;
window.onpopstate = popstateCallback;

function pushState(author_id, path) {
    window.history.pushState({'author_id' : author_id}, '', path);
}

function popState() {
    history.back();
}

function popstateCallback() {
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

function process404Response() {
    clearContent();
    generateHTML404();
}

function generateHTML404() {
    const container = document.querySelector('.container');

    const h1 = document.createElement('h1');
    h1.appendChild(document.createTextNode('Error 404 - Page not found!'));

    container.appendChild(h1);
}

function processResponse(response, callback_200, callback_err) {
    if (response.status === 404) {
        process404Response();
    } else if (response.status === 200) {
        if (callback_200 == null) {
            popState();
        } else {
            callback_200(response);
        }
    } else if (response.status === 400 || response.status === 500) {
        callback_err(response.status, JSON.parse(response.responseText));
    }
}

