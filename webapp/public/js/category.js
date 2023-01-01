function showInput(id) {
    var form = document.getElementById('edit-' + id);
    form.style.display = 'block';
}

function updateCategory(id) {
    var form = document.getElementById('edit-' + id);
    var categoryName = document.getElementById('category-' + id).value;
    var csrfToken = document.querySelector('meta[name=csrf-token]').getAttribute('content');

    var xhr = new XMLHttpRequest();
    xhr.open('PUT', '/categories/' + id + '/edit');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
    xhr.onload = function() {
        form.style.display = 'none';
    };
    xhr.send('name=' + encodeURIComponent(categoryName));
}