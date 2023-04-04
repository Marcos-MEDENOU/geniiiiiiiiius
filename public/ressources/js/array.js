document.addEventListener("DOMContentLoaded", () => {
    let clique = document.querySelectorAll(".clique");
    let all_checked = document.getElementById("all_checked");
    let update = document.querySelector(".update");
    let deletes = document.querySelector(".delete");

    all_checked.addEventListener("click", () => {
        if (all_checked.checked === true) {
            clique.forEach(el => {
                el.checked = true;
            })
            update.style = "background-color: rgb(33, 64, 96);";
            update.setAttribute("disabled", "disabled");
        } else {
            clique.forEach(el => {
                el.checked = false;
            })
            update.style = "background-color: rgb(58, 142, 226);";
            update.removeAttribute("disabled", "disabled");
        }
    })

    let longueur = 0;
    clique.forEach(el => {
        el.addEventListener("click", () => {
            if (el.checked === true) {
                longueur += 1;
            } else {
                longueur -= 1;
            }
            
            if (longueur == 1) {
                update.style = "background-color: rgb(58, 142, 226);";
                update.removeAttribute("disabled", "disabled");
            } else {
                update.style = "background-color: rgb(33, 64, 96);";
                update.setAttribute("disabled", "disabled");
            }
        })
    })

    update.addEventListener("click", () => {
        clique.forEach(el => {
            if (el.checked === true) {
                let parent = el.parentElement.parentElement;
                let first = parent.childNodes[1];
                let id = first.textContent;
                console.log("Modification effectuée");
            }
        })
    })

    deletes.addEventListener("click", () => {
        clique.forEach(el => {
            if (el.checked === true) {
                let parent = el.parentElement.parentElement;
                let first = parent.childNodes[1];
                let id = first.textContent;
                parent.remove();
            }
        })
    })
})