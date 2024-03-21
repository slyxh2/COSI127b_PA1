
if (awardArray) {
    handleAward(awardArray);
} else if (oldAndYoungPerson) {
    handleOldAndYoung(oldAndYoungPerson[0]);
}

function handleAward(awardArray) {
    appendTableThread(['Person Name', 'Motion Picture', 'Award Year', 'Award Count']);
    const tableBody = document.querySelector('#motion-table-body');
    awardArray.forEach(award => {
        const { person_name, movie_name, award_year, award_count } = award;
        appendTableRow({ person_name, movie_name, award_year, award_count }, tableBody);
    })
}

function handleOldAndYoung(data) {
    appendTableThread(['Oldest Person Name', 'Oldest Age', 'Yongest Person Name', 'Yongest Age']);
    const tableBody = document.querySelector('#motion-table-body');

    const { oldest_name, oldest_age, youngest_name, youngest_age } = data;
    appendTableRow({ oldest_name, oldest_age, youngest_name, youngest_age }, tableBody);

}