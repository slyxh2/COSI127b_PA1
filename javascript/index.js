handleRenderAllTable();
handleLogin();
checkUserStatus();

function handleRenderAllTable() {
    const tableList = document.querySelector('#table-list');
    const ul = document.createElement('ul');

    allTable.forEach(table => {
        const li = document.createElement('li');
        li.textContent = table.table_name;
        ul.appendChild(li);
    });

    tableList.appendChild(ul);
};

function handleLogin() {
    const loginBtn = document.querySelector('#login-btn');
    const emailInput = document.querySelector('#user-email');
    loginBtn.addEventListener('click', () => {
        fetch(`./api/user.php?email=${emailInput.value}`)
            .then(response => response.json())
            .then(data => {
                if (data.length > 0) {
                    console.log(data);
                    const { email, age, name } = data[0];
                    sessionStorage.setItem('user', JSON.stringify({ email, age, name }));
                    location.reload();
                } else {
                    handleLoginError("This email is not exist!");
                }
            })
            .catch(error => console.error(error));
    })
}

function handleLoginError(message) {
    const modalBody = document.querySelector('.modal-body');
    const pElement = document.createElement('p');
    pElement.textContent = message;
    pElement.setAttribute('class', "error");
    modalBody.appendChild(pElement);
}

function checkUserStatus() {
    const loginModal = document.querySelector('#login-modal');
    let userInf = sessionStorage.getItem('user');
    if (userInf) {
        const { email, name } = JSON.parse(userInf);
        loginModal.style.display = 'none';
        const body = document.querySelector('#user-inf-block');
        const header = document.createElement('h3');
        header.textContent = `Email: ${email} Name: ${name}`;

        const logoutBtn = document.createElement('button');
        logoutBtn.style.display = 'block';
        logoutBtn.style.margin = 'auto';

        logoutBtn.setAttribute('class', 'btn btn-danger');
        logoutBtn.textContent = 'Logout'
        logoutBtn.addEventListener('click', () => {
            sessionStorage.removeItem('user');
            location.reload();
        })
        body.appendChild(header);
        body.appendChild(logoutBtn);

    }
}