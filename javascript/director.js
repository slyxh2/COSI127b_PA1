console.log(directorArray);
handleDirector(directorArray);
function handleDirector(directorArray) {
    appendTableThread(['TV Series Name', 'Director Name']);
    const tableBody = document.querySelector('#motion-table-body');
    directorArray.forEach(director => {
        const { tv_name, director_name } = director;
        const row = document.createElement('tr');
        row.setAttribute('class', 'movie_table_row')

        const nameTd = document.createElement('td');
        nameTd.textContent = tv_name;
        const directorTd = document.createElement('td');
        directorTd.textContent = director_name;

        row.appendChild(nameTd);
        row.appendChild(directorTd);


        tableBody.appendChild(row);
    })
}
