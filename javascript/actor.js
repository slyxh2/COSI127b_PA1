console.log(peopleArray);
const { type } = peopleArray.pop();
if (type === 'default') {
    handlePeople(peopleArray);
} else if (type === 'top-five') {
    handleTopFive(peopleArray);
} else if (type === 'same-birth') {
    handleSameBirth(peopleArray)
}

function handlePeople(peopleArray) {
    appendTableThread(['Person Name', 'Nationality', 'Gender', 'DOB']);
    const tableBody = document.querySelector('#motion-table-body');
    peopleArray.forEach(people => {
        const { name, nationality, gender, DOB } = people;
        appendTableRow({ name, nationality, gender, DOB }, tableBody);
    })
}

function handleTopFive(peopleArray) {
    console.log(peopleArray);
    appendTableThread(['Movie Name', 'People Number', 'Role Number']);
    const tableBody = document.querySelector('#motion-table-body');
    peopleArray.forEach(people => {
        const { movie_name, people_count, role_count } = people;
        appendTableRow({ movie_name, people_count, role_count }, tableBody);
    })
}

function handleSameBirth(peopleArray) {
    console.log(peopleArray);
    appendTableThread(['Person 1', 'Person 2', 'DOB']);
    const tableBody = document.querySelector('#motion-table-body');
    peopleArray.forEach(people => {
        const { name1, name2, dob } = people;
        appendTableRow({ name1, name2, dob }, tableBody);
    })
}