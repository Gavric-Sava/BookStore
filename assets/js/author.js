function requestAuthorList() {
    const response = fetch('http://bookstore.test/spa/authors');
    response.then((response) => processResponse(response, (response) => {
        response.text().then((body) => {
            generateHTMLAuthorList(JSON.parse(body));
        });
    }, null))
}

function generateHTMLAuthorList(author_list) {
    const container = document.querySelector('.container');

    const wrapper = document.createElement('div');
    wrapper.className = 'wrapper wrapper-list author-list';

    // list header
    const h1 = document.createElement("h1");
    h1.appendChild(document.createTextNode("Author list"));
    wrapper.appendChild(h1);

    // list table
    const table = document.createElement('table');

    // list table columns
    let col = document.createElement('col');
    col.className = "first-column";
    table.appendChild(col);
    col = document.createElement('col');
    col.className = "second-column";
    table.appendChild(col);
    col = document.createElement('col');
    col.className = "third-column";
    table.appendChild(col);

    // list table headings row
    const thead = document.createElement('thead');
    let tr = document.createElement('tr');

    // list table headings
    let th = document.createElement('th');
    th.className = 'first';
    th.appendChild(document.createTextNode("Author"));
    tr.append(th);


    th = document.createElement('th');
    th.className = 'books';
    th.appendChild(document.createTextNode("Books"));
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
    image_edit.src = '../../../../assets/images/edit.jpg';
    image_edit.className = 'icon edit';

    let image_delete = document.createElement('img');
    image_delete.src = '../../../../assets/images/delete.png';
    image_delete.className = 'icon';

    let image_create = document.createElement('img');
    image_create.src = '../../../../assets/images/create.png';
    image_create.className = 'icon create';

    let alert_img = document.createElement('img');
    alert_img.src = '../../../../assets/images/alert.png';

    // rows and columns of list table
    for (let i = 0; i < author_list.length; i++) {
        let author = author_list[i].author;
        let book_count = author_list[i].book_count;
        const tr = tbody.insertRow();

        for (let j = 0; j < 3; j++) {
            const td = tr.insertCell();
            if (j === 0) {
                const book_list_link = document.createElement('a');
                book_list_link.href = `spa/authors/${author.id}/books`;
                book_list_link.addEventListener('click', function(event) {
                    event.preventDefault();
                    pushState(author.id,`/spa/authors/${author.id}/books`);
                    requestBookList(author.id);
                });
                book_list_link.appendChild(
                    document.createTextNode(
                        author.firstname +
                        " " +
                        author.lastname
                    )
                );
                td.appendChild(book_list_link);
                td.className = 'first';
            } else if (j === 1) {
                td.appendChild(document.createTextNode(book_count));
                td.className = 'books';
            } else {
                let a = document.createElement('a');
                a.addEventListener('click', function() {
                    clearContent();
                    pushState(null, '/spa/authors/edit/' + author.id);
                    generateHTMLAuthorEdit(
                        author.id,
                        author.firstname,
                        author.lastname,
                    );
                })
                a.appendChild(image_edit.cloneNode());
                td.appendChild(a);

                a = document.createElement('a');
                a.addEventListener('click', function() {
                    clearContent();
                    pushState(null, '/spa/authors/delete/' + author.id);
                    generateHTMLAuthorDelete(
                        author.id,
                        author.firstname,
                        author.lastname
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
        pushState(null, '/spa/authors/create');
        generateHTMLAuthorCreate();
    });
    wrapper.appendChild(a);

    container.appendChild(wrapper);
}

function generateHTMLAuthorForm() {
    const container = document.querySelector('.container');

    const wrapper = document.createElement('div');
    wrapper.className = 'wrapper wrapper-form';

    // header div
    const header = document.createElement("div");
    header.className = 'header';

    wrapper.appendChild(header);

    // form
    const form = document.createElement('form');
    form.method = 'post';

    // first name div
    const first_name_div = document.createElement('div');
    first_name_div.className = 'form-item';

    // first name label
    const first_name_label = document.createElement('span');
    first_name_label.appendChild(document.createTextNode('First name'));
    first_name_div.appendChild(first_name_label);

    // first name input
    const first_name_input = document.createElement('input');
    first_name_input.type = 'text';
    first_name_input.name = 'first_name';
    first_name_div.appendChild(first_name_input);

    // first name error span
    const first_name_error = document.createElement('span');
    first_name_error.className = 'error first_name_error';
    first_name_div.appendChild(first_name_error);

    form.appendChild(first_name_div);

    // last name div
    const last_name_div = document.createElement('div');
    last_name_div.className = 'form-item';

    // last name label
    const last_name_label = document.createElement('span');
    last_name_label.appendChild(document.createTextNode('Last name'));
    last_name_div.appendChild(last_name_label);

    // last name input
    const last_name_input = document.createElement('input');
    last_name_input.type = 'text';
    last_name_input.name = 'last_name';
    last_name_div.appendChild(last_name_input);

    // last name error span
    const last_name_error = document.createElement('span');
    last_name_error.className = 'error last_name_error';
    last_name_div.appendChild(last_name_error);

    form.appendChild(last_name_div);

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

function generateHTMLAuthorCreate() {
    generateHTMLAuthorForm();

    const header = document.getElementsByClassName('header')[0];
    // header span
    const header_span = document.createElement('span');
    header_span.appendChild(document.createTextNode('Author Create'));
    header.appendChild(header_span);

    const form = document.getElementsByTagName('form')[0];
    // submit create event listener
    form.addEventListener("submit", (event) => {
        event.preventDefault();

        const httpRequest = new XMLHttpRequest();
        if (!httpRequest) {
            return false;
        }

        httpRequest.onreadystatechange = function() {
            if (httpRequest.readyState === XMLHttpRequest.DONE) {
                processResponse(httpRequest, null, updateAuthorForm);
            }
        };

        httpRequest.open('POST', 'http://bookstore.test/spa/authors/create');
        const first_name_param = 'first_name=' + document.getElementsByName('first_name')[0].value;
        const last_name_param = 'last_name=' + document.getElementsByName('last_name')[0].value;

        httpRequest.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        httpRequest.send(first_name_param + '&' + last_name_param);
    }, true);
}

function generateHTMLAuthorEdit(id, firstname, lastname) {
    generateHTMLAuthorForm();

    const header = document.getElementsByClassName('header')[0];
    // header span
    const header_span = document.createElement('span');
    header_span.appendChild(document.createTextNode('Author Create ' + id));
    header.appendChild(header_span);

    // old author attributes
    const first_name_input = document.getElementsByName('first_name')[0];
    first_name_input.value = firstname;
    const last_name_input = document.getElementsByName('last_name')[0];
    last_name_input.value = lastname;

    const form = document.getElementsByTagName('form')[0];
    // submit create event listener
    form.addEventListener("submit", (event) => {
        event.preventDefault();

        const httpRequest = new XMLHttpRequest();
        if (!httpRequest) {
            return false;
        }

        httpRequest.onreadystatechange = function() {
            if (httpRequest.readyState === XMLHttpRequest.DONE) {
                processResponse(httpRequest, null, updateAuthorForm);
            }
        };

        httpRequest.open('POST', 'http://bookstore.test/spa/authors/edit/' + id);
        const first_name_param = 'first_name=' + document.getElementsByName('first_name')[0].value;
        const last_name_param = 'last_name=' + document.getElementsByName('last_name')[0].value;

        httpRequest.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        httpRequest.send(first_name_param + '&' + last_name_param);
    }, true);
}

function updateAuthorForm(status, response) {
    if (status === 400) {
        document.getElementsByName('first_name')[0].value = response.first_name;
        if ('first_name_error' in response) {
            document.getElementsByClassName('first_name_error')[0].textContent = response.first_name_error;
        }

        document.getElementsByName('last_name')[0].value = response.last_name;
        if ('last_name_error' in response) {
            document.getElementsByClassName('last_name_error')[0].textContent = response.last_name_error;
        }
    } else if (status === 500) {
        alert(response.error);
    }
}

function generateHTMLAuthorDelete(id, firstname, lastname) {
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
        'You are about to delete the author ' + firstname + ' ' + lastname + '.\n' +
        'If you proceed with this action Application will permanently delete all books related to this author.'
    ));
    wrapper.appendChild(text);

    const form = document.createElement('form');
    form.addEventListener('submit', (event) =>  {
        event.preventDefault();

        const httpRequest = new XMLHttpRequest();
        if (!httpRequest) {
            return false;
        }

        httpRequest.onreadystatechange = function() {
            if (httpRequest.readyState === XMLHttpRequest.DONE) {
                processResponse(httpRequest, null, null);
            }
        };

        httpRequest.open('POST', 'http://bookstore.test/spa/authors/delete/' + id);
        httpRequest.send();
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

