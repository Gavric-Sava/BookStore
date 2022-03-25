function requestBookList(author_id) {
    const response = fetch(`http://bookstore.test/spa/authors/${author_id}/books`);
    response.then((response) => processBookListResponse(response, author_id));
}

function processBookListResponse(response, author_id) {
    if (response.status === 200) {
        response.text().then((body) => {
            body = JSON.parse(body);
            clearContent();
            generateHTMLBookList(body);
        });
    }

    return null;
}

function generateHTMLBookList(book_list) {
    const container = document.querySelector('.container');

    const wrapper = document.createElement('div');
    wrapper.className = 'wrapper wrapper-list book-list';

    // list header
    const h1 = document.createElement("h1");
    h1.appendChild(document.createTextNode("Book list"));
    wrapper.appendChild(h1);

    // list table
    const table = document.createElement('table');

    // list table columns
    let col = document.createElement('col');
    col.className = "first-column";
    table.appendChild(col);
    col = document.createElement('col');
    col.className = "second-column last";
    table.appendChild(col);

    // list table headings row
    const thead = document.createElement('thead');
    let tr = document.createElement('tr');

    // list table headings
    let th = document.createElement('th');
    th.className = 'first';
    th.appendChild(document.createTextNode("Book"));
    tr.append(th);

    th = document.createElement('th');
    th.className = 'last';
    th.appendChild(document.createTextNode("Actions"));
    tr.append(th);

    thead.append(tr);

    table.append(thead);

    // list table body
    let tbody = document.createElement('tbody');

    // function images
    let image_edit = document.createElement('img');
    image_edit.src = '../../../../../assets/images/edit.jpg';
    image_edit.className = 'icon edit';

    let image_delete = document.createElement('img');
    image_delete.src = '../../../../../assets/images/delete.png';
    image_delete.className = 'icon';

    let image_create = document.createElement('img');
    image_create.src = '../../../../../assets/images/create.png';
    image_create.className = 'icon create';

    // rows and columns of list table
    for (let i = 0; i < book_list.length; i++) {
        let book = book_list[i];
        const tr = tbody.insertRow();

        for (let j = 0; j < 2; j++) {
            const td = tr.insertCell();
            if (j === 0) {
                td.appendChild(
                    document.createTextNode(
                        book.title +
                        " " +
                        book.year
                    )
                );
                td.className = 'first';
            } else {
                let a = document.createElement('a');
                a.addEventListener('click', function() {
                    clearContent();
                    pushState(null, `/spa/authors/books/edit/${book.id}`);
                    generateHTMLBookEdit(
                        book.id,
                        book.title,
                        book.year,
                        book.author_id
                    );
                })
                a.appendChild(image_edit.cloneNode());
                td.appendChild(a);

                a = document.createElement('a');
                a.addEventListener('click', function() {
                    clearContent();
                    pushState(null, `/spa/authors/books/delete/${book.id}`);
                    generateHTMLBookDelete(
                        book.id,
                        book.title,
                        book.year,
                        book.author_id
                    );
                })
                a.appendChild(image_delete.cloneNode());
                td.appendChild(a);

                td.className = 'last';
            }
        }
    }

    table.appendChild(tbody);

    wrapper.appendChild(table);

    // create 'button'
    let a = document.createElement('a');
    a.className = 'create_link';
    a.appendChild(image_create);
    a.addEventListener('click', function() {
        clearContent();
        pushState(history.state.author_id, `/spa/authors/${history.state.author_id}/books/create`);
        generateHTMLBookCreate();
    });
    wrapper.appendChild(a);

    container.appendChild(wrapper);
}

function generateHTMLBookEdit(id, title, year, author_id) {
    const container = document.querySelector('.container');

    const wrapper = document.createElement('div');
    wrapper.className = 'wrapper wrapper-form';

    // header div
    const header = document.createElement("div");
    header.className = 'header';

    // header span
    const header_span = document.createElement('span');
    header_span.appendChild(document.createTextNode('Book Edit ' + id));
    header.appendChild(header_span);

    wrapper.appendChild(header);

    // form
    const form = document.createElement('form');
    form.method = 'post';
    form.addEventListener("submit", function(event) {
        submitEditBookInput(event, id, author_id);
    }, true);

    // title div
    const title_div = document.createElement('div');
    title_div.className = 'form-item';

    // title label
    const title_label = document.createElement('span');
    title_label.appendChild(document.createTextNode('Title'));
    title_div.appendChild(title_label);

    // title input
    const title_input = document.createElement('input');
    title_input.type = 'text';
    title_input.name = 'title';
    title_input.value = title;
    title_div.appendChild(title_input);

    // title error span
    const title_error = document.createElement('span');
    title_error.className = 'error';
    title_div.appendChild(title_error);

    form.appendChild(title_div);

    // year div
    const year_div = document.createElement('div');
    year_div.className = 'form-item';

    // year label
    const year_label = document.createElement('span');
    year_label.appendChild(document.createTextNode('Year'));
    year_div.appendChild(year_label);

    // year input
    const year_input = document.createElement('input');
    year_input.type = 'text';
    year_input.name = 'year';
    year_input.value = year;
    year_div.appendChild(year_input);

    // year error span
    const year_error = document.createElement('span');
    year_error.className = 'error';
    year_div.appendChild(year_error);

    form.appendChild(year_div);

    const button_div = document.createElement('div');
    button_div.className = 'button';

    const submit_button = document.createElement('input');
    submit_button.type = 'submit';
    submit_button.name = 'submit';
    submit_button.value = 'Save';
    button_div.appendChild(submit_button);

    form.appendChild(button_div);

    wrapper.appendChild(form);

    container.appendChild(wrapper);
}

function submitEditBookInput(event, id, author_id) {
    event.preventDefault();

    const httpRequest = new XMLHttpRequest();
    if (!httpRequest) {
        return false;
    }

    httpRequest.onreadystatechange = function() {
        if (httpRequest.readyState === XMLHttpRequest.DONE) {
            if (httpRequest.status === 200) {
                clearContent(); // TODO test
                popState();
            } else if (httpRequest.status !== 404) {
                updateBookEdit(JSON.parse(httpRequest.responseText));
            } else {
                process404Response();
            }
        }
    };

    httpRequest.open('POST', `http://bookstore.test/spa/authors/${author_id}/books/edit/${id}`);
    const title_param = 'title=' + document.getElementsByName('title')[0].value;
    const year_param = 'year=' + document.getElementsByName('year')[0].value;

    httpRequest.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    httpRequest.send(title_param + '&' + year_param);
}

function updateBookEdit(status, response) {
    if (status === 400) {
        document.getElementsByName('title')[0].value = response.title;
        if ('title_error' in response) {
            document.getElementsByClassName('title_error')[0].textContent = response.title_error;
        }

        document.getElementsByName('year')[0].value = response.year;
        if ('year_error' in response) {
            document.getElementsByClassName('year_error')[0].textContent = response.year_error;
        }
    } else if (status === 500) {
        alert(response.error);
    }
}

function generateHTMLBookDelete(id, title, year, author_id) {
    const container = document.querySelector('.container');

    const wrapper = document.createElement('div');
    wrapper.className = 'wrapper wrapper-dialog';

    const header = document.createElement('div');
    header.className = 'header';

    const alert_img = document.createElement('img');
    alert_img.src = '../../../../../assets/images/alert.png';
    header.appendChild(alert_img);

    const header_h2 = document.createElement('h2');
    header_h2.appendChild(document.createTextNode('Delete Author'));
    header.appendChild(header_h2);

    wrapper.appendChild(header_h2);

    const text = document.createElement('div');
    text.className = 'text';
    text.appendChild(document.createTextNode(
        'You are about to delete the book ' + title + '(' + year + ').'
    ));
    wrapper.appendChild(text);

    const form = document.createElement('form');
    form.addEventListener('submit', function(event) {
        submitDeleteBook(event, id, author_id);
    });
    form.method = 'post';
    form.className = 'buttons';

    const btn_delete = document.createElement('button');
    btn_delete.type = 'submit';
    btn_delete.className = 'delete';
    btn_delete.appendChild(document.createTextNode('Delete'));
    form.appendChild(btn_delete);

    const btn_cancel = document.createElement('button');
    btn_cancel.addEventListener('click', function(event) {
        event.preventDefault();
        popState();
    })
    btn_cancel.className = 'cancel';
    btn_cancel.appendChild(document.createTextNode('Cancel'));
    form.appendChild(btn_cancel);

    wrapper.appendChild(form);

    container.appendChild(wrapper);
}

function submitDeleteBook(event, id, author_id) {
    event.preventDefault();

    const httpRequest = new XMLHttpRequest();
    if (!httpRequest) {
        return false;
    }

    httpRequest.onreadystatechange = function() {
        if (httpRequest.readyState === XMLHttpRequest.DONE) {
            if (httpRequest.status !== 404) {
                alert(httpRequest.responseText);
                clearContent();
                popState();
                // requestAuthorList();
            }
            else {
                process404Response();
            }
        }
    };

    httpRequest.open('POST', `http://bookstore.test/spa/authors/${author_id}/books/delete/${id}`);
    httpRequest.send();
}

function generateHTMLBookCreate() {
    const container = document.querySelector('.container');

    const wrapper = document.createElement('div');
    wrapper.className = 'wrapper wrapper-form';

    // header div
    const header = document.createElement("div");
    header.className = 'header';

    // header span
    const header_span = document.createElement('span');
    header_span.appendChild(document.createTextNode('Book Create'));
    header.appendChild(header_span);

    wrapper.appendChild(header);

    // form
    const form = document.createElement('form');
    form.method = 'post';
    form.addEventListener("submit", submitCreateBookInput, true);

    // title div
    const title_div = document.createElement('div');
    title_div.className = 'form-item';

    // title label
    const title_label = document.createElement('span');
    title_label.appendChild(document.createTextNode('Title'));
    title_div.appendChild(title_label);

    // title input
    const title_input = document.createElement('input');
    title_input.type = 'text';
    title_input.name = 'title';
    title_div.appendChild(title_input);

    // title error span
    const title_error = document.createElement('span');
    title_error.className = 'error';
    title_div.appendChild(title_error);

    form.appendChild(title_div);

    // year div
    const year_div = document.createElement('div');
    year_div.className = 'form-item';

    // year label
    const year_label = document.createElement('span');
    year_label.appendChild(document.createTextNode('Year'));
    year_div.appendChild(year_label);

    // year input
    const year_input = document.createElement('input');
    year_input.type = 'text';
    year_input.name = 'year';
    year_div.appendChild(year_input);

    // year error span
    const year_error = document.createElement('span');
    year_error.className = 'error';
    year_div.appendChild(year_error);

    form.appendChild(year_div);

    const button_div = document.createElement('div');
    button_div.className = 'button';

    const submit_button = document.createElement('input');
    submit_button.type = 'submit';
    submit_button.name = 'submit';
    submit_button.value = 'Save';
    button_div.appendChild(submit_button);

    form.appendChild(button_div);

    wrapper.appendChild(form);

    container.appendChild(wrapper);
}

function submitCreateBookInput(event) {
    event.preventDefault();

    const httpRequest = new XMLHttpRequest();
    if (!httpRequest) {
        return false;
    }

    httpRequest.onreadystatechange = function() {
        if (httpRequest.readyState === XMLHttpRequest.DONE) {
            if (httpRequest.status === 200) {
                popState();
                clearContent();
                requestBookList();
            } else if (httpRequest.status !== 404) {
                updateBookForm(JSON.parse(httpRequest.responseText));
            } else {
                process404Response();
            }
        }
    };

    httpRequest.open('POST', `http://bookstore.test/spa/authors/${history.state.author_id}/books/create`);
    const title_param = 'title=' + document.getElementsByName('title')[0].value;
    const year_param = 'year=' + document.getElementsByName('year')[0].value;

    httpRequest.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    httpRequest.send(title_param + '&' + year_param);
}
