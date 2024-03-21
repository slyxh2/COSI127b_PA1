// render all motion to table
console.log(motionArray);
const { type } = motionArray.pop();

handleAllCountry(allCountry);

if (type === 'country') {
    handleNameMotion(motionArray);
} else if (type === 'average') {
    handleAverage(motionArray)
} else {
    handleFullInformationMotion(motionArray);
}


async function handleFullInformationMotion(motionArray) {
    appendTableThread(['Name', 'Production', 'Budget', 'Rating']);
    const likeSet = await getUserLike();
    const tableBody = document.querySelector('#motion-table-body');
    motionArray.forEach(motion => {
        const { id, name, production, budget, rating } = motion;
        const likeFlag = likeSet.has(id);
        const row = document.createElement('tr');
        row.setAttribute('movie_id', id);
        row.setAttribute('class', 'movie_table_row');

        const nameTd = document.createElement('td');
        nameTd.textContent = name;
        const productionTd = document.createElement('td');
        productionTd.textContent = production;
        const budgetTd = document.createElement('td');
        budgetTd.textContent = budget;
        const ratingTd = document.createElement('td');
        ratingTd.textContent = rating;

        const likeTd = document.createElement('td');
        if (!likeFlag) {
            const likeBtn = document.createElement('button');
            likeBtn.textContent = 'Like It!!'
            likeBtn.setAttribute('movie_id', id);
            likeBtn.addEventListener('click', (ev) => {
                const mid = ev.target.getAttribute('movie_id')
                postLike(mid);
            });
            likeTd.appendChild(likeBtn);
        } else {
            likeTd.textContent = 'You Already Like!'
        }

        row.appendChild(nameTd);
        row.appendChild(productionTd);
        row.appendChild(budgetTd);
        row.appendChild(ratingTd);
        row.appendChild(likeTd);

        tableBody.appendChild(row);
    })
}

function handleNameMotion(motionArray) {
    appendTableThread(['Name']);
    const tableBody = document.querySelector('#motion-table-body');
    motionArray.forEach(motion => {
        const { name } = motion;
        const row = document.createElement('tr');
        row.setAttribute('class', 'movie_table_row')

        const nameTd = document.createElement('td');
        nameTd.textContent = name;

        row.appendChild(nameTd);

        tableBody.appendChild(row);
    })

}

function handleAllCountry(allCountry) {
    const select = document.querySelector('#country-select');
    allCountry.forEach(item => {
        const { country } = item;
        const option = document.createElement('option');
        option.setAttribute('value', country);
        option.textContent = country;
        select.appendChild(option);
    })
}

function handleAverage(motionArray) {
    appendTableThread(['Motion Picture', 'Rating']);
    const tableBody = document.querySelector('#motion-table-body');
    motionArray.forEach(motion => {
        const { movie_name, rating } = motion;
        appendTableRow({ movie_name, rating }, tableBody);
    })
}

function handleTableRow() {
    // handle all table row link
    const movieTableRow = document.querySelectorAll('.movie_table_row');

    for (let i = 0; i < movieTableRow.length; i++) {
        const row = movieTableRow[i];
        const movieId = row.getAttribute('movie_id'); // movie id
        row.addEventListener('click', (e) => {
            if (e.target.getAttribute('class') === 'like_btn') return;
            window.open(`./moviedetail.php?id=${movieId}`, '_blank');
        })
    }
}

async function getUserLike() {
    const userInf = sessionStorage.getItem('user');
    const set = new Set();
    if (!userInf) return set;
    const { email } = JSON.parse(userInf);
    await fetch(`./api/like.php?email=${email}`)
        .then(response => response.json())
        .then(data => {
            data.forEach(item => {
                set.add(item.mpid);
            })
        })
        .catch(error => console.error(error));
    return set;
}

function postLike(mid) {
    const userInf = sessionStorage.getItem('user');
    if (!userInf) {
        alert('You need to login to use like function!!!');
    }
    const { email } = JSON.parse(userInf);
    fetch(`./api/like.php`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ mid, email })

    }).then(response => response.json())
        .then(data => {
            console.log(data);
        })
        .then(() => location.reload())
        .catch(error => console.error(error));
}