function showNotifs() {
  var form = document.getElementById('notifs');
  
  if (form.style.display == 'none') {
    form.style.display = 'block';
  }
  else {
    form.style.display = 'none';
  }
}

function deleteNotif(id) {
  var form = document.getElementsByClassName('notif');
  var csrfToken = document.querySelector('meta[name=csrf-token]').getAttribute('content');

  var xhr = new XMLHttpRequest();
  xhr.open('DELETE', '/notifications/' + id + '/delete');
  xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
  xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
  xhr.onload = function() {
    form.style.display = 'none';
  };
  xhr.send();
  location.reload();
}