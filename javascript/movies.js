console.log(movieArray)
handleMovieLike(movieArray);
function handleMovieLike(movieArray) {
    appendTableThread(['Movie Name', 'Like Number']);
    const tableBody = document.querySelector('#motion-table-body');
    movieArray.forEach(movie => {
        const { movie_name, like_count } = movie;
        appendTableRow({ movie_name, like_count }, tableBody);
    })
}