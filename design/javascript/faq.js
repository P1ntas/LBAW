let toggle = document.getElementsByClassName('FAQtoggle');
let answer = document.getElementsByClassName('answer');
let icon = document.getElementsByClassName('icon');

for (let i = 0; i < toggle.length; i++) {   
    toggle[i].addEventListener('click', () => {
        if (parseInt(answer[i].style.height) != answer[i].scrollHeight) {
            answer[i].style.height = answer[i].scrollHeight + "px";
            toggle[i].style.color = "#0084e9";
            icon[i].classList.remove('fa-plus');
            icon[i].classList.add('fa-minus');
        }
        else {
            answer[i].style.height = "0px";
            toggle[i].style.color = "#111130";
            icon[i].classList.remove('fa-minus');
            icon[i].classList.add('fa-plus');
        }
        for (let j = 0; j < answer.length; j++) {
            if (j !== i) {
                answer[j].style.height = "0px";
                toggle[j].style.color = "#111130";
                icon[j].classList.remove('fa-minus');
                icon[j].classList.add('fa-plus');
            }
        }
    });
}