function onlyOne(checkbox) {
    var checkboxes = document.getElementsByName('check')
    checkboxes.forEach((item) => {
        if (item !== checkbox) item.checked = false
    })
}

document.querySelector('.close-button').addEventListener('click', function() {
    document.querySelector('.notification').style.display = 'none';
    document.querySelector('.close-button').style.display = 'none';
});