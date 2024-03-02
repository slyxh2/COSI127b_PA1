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