console.log(roleArray);
handleRole(roleArray);
function handleRole(roleArray) {
    appendTableThread(['Person Name', 'Motion Picture', 'Role Number', 'Rating']);
    const tableBody = document.querySelector('#motion-table-body');
    roleArray.forEach(role => {
        const { person_name, movie_name, role_count, rating } = role;
        appendTableRow({ person_name, movie_name, role_count, rating }, tableBody);
    })
}