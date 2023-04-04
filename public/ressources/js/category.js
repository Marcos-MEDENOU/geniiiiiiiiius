let validation = document.getElementById("validation_category");
let delete_category = document.querySelectorAll(".delete_category");

document.addEventListener("DOMContentLoaded", () => {
    validation.addEventListener("click", (e) => {
        e.preventDefault();
        let category_name = document.getElementById("category_name").value;
        let category_description = document.getElementById("category_description").value;
        if ((category_name.trim() !== "") && (category_description.trim() !== "")) {
            let data = {
                category_name: category_name,
                category_description: category_description
            }
            data = JSON.stringify(data);
            let option = {
                header: {
                    content: "application/json"
                },
                body: data,
                method: "post"
            }
            fetch("?ajax=category-controller&action=verify-inputs", option).then(response => response.json()).then(response => {
                if (response == "valid_input") {
                    fetch("?ajax=category-controller&action=add-category", option).then(response => response.json()).then(response => {
                        if (response == "exist") {
                            console.log("La catégorie existe déjà!!");
                        } else {
                            window.location.href = response;
                        }
                    })
                } else {
                    console.log("Remplissez tous les champs!!!");
                }
            })
        }
    })

    delete_category.forEach(el => {
        el.addEventListener("click", (e) => {
            e.preventDefault();
            let parent = el.parentElement.parentElement.parentElement;
            let data = {
                id: el.value
            }
            data = JSON.stringify(data);
            let option = {
                header: {
                    content: "application/json"
                },
                body: data,
                method: "post"
            }
            fetch("?ajax=category-controller&action=delete-one-category", option)
            parent.remove();
        })
    })

})