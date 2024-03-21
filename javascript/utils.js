function appendTableThread(arr) {
    const tableThead = document.querySelector('#motion-thread');
    const tr = document.createElement('tr');
    arr.forEach(header => {
        const th = document.createElement('th');
        th.textContent = header;
        tr.appendChild(th);
    })
    tableThead.appendChild(tr);
}

function appendTableRow(data, tableBody) {
    const row = document.createElement('tr');
    row.setAttribute('class', 'movie_table_row')

    for (const [_, value] of Object.entries(data)) {
        const td = document.createElement('td');
        td.textContent = value;
        row.appendChild(td);
    }
    tableBody.appendChild(row);
}