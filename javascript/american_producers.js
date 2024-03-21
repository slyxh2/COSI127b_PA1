console.log(movieArray);
handleMovie(movieArray);


function handleMovie(movieArray) {
    appendTableThread(['Producer Name', 'Movie Name', 'Box Office Collection', 'Budget']);
    const tableBody = document.querySelector('#motion-table-body');

    movieArray.forEach(movie => {
        const { person_name, movie_name, collection, budget } = movie;
        appendTableRow({ person_name, movie_name, collection, budget }, tableBody);
    })

}