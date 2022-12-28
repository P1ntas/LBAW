const description = document.querySelector("#description");
const reviewBook = document.querySelector("#reviewBook");
const details = document.querySelector("#details");
const autor = document.querySelector("#autor");

function actButton(a, b) {
    a.addEventListener("click", () => {
        description.classList.remove("activeLabel");
        reviewBook.classList.remove("activeLabel");
        details.classList.remove("activeLabel");
        autor.classList.remove("activeLabel");
        document.getElementById('bookDescription').classList.add('hideBook');
        document.getElementById('bookReview').classList.add('hideBook');
        document.getElementById('detailsBook').classList.add('hideBook');
        document.getElementById('bookAutor').classList.add('hideBook');
        a.classList.add("activeLabel");
        switch (a) {
            case description:
                document.getElementById('bookDescription').classList.remove('hideBook');
                break;
            case reviewBook:
                document.getElementById('bookReview').classList.remove('hideBook');
                break;
            case details:
                document.getElementById('detailsBook').classList.remove('hideBook');
                break;
            case autor:
                document.getElementById('bookAutor').classList.remove('hideBook');
                break;
        }
    })
}

actButton(description);
actButton(reviewBook);
actButton(details);
actButton(autor);
