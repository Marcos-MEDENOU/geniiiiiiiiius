let validation = document.getElementById("validation_contact");

document.addEventListener("DOMContentLoaded", () => {
    validation.addEventListener("click", (e) => {
        e.preventDefault();
        let email = document.getElementById("email").value;
        let name = document.getElementById("name").value;
        let theme = document.getElementById("subject").value;
        let corps = document.getElementById("message").value;
        if ((email !== "") && (name !== "") && (theme !== "") && (corps !== "")) {
            let data = {
                email: email,
                name: name,
                theme: theme,
                corps: corps
            }
            data = JSON.stringify(data);
            let option = {
                header: {
                    content: "application/json"
                },
                body: data,
                method: "post"
            }
            fetch("?ajax=contact-controller&action=verify-inputs", option).then(response => response.json()).then(response => {
                if (response == "valid_input") {
                    fetch("?ajax=contact-controller&action=verify-email", option).then(response => response.json()).then(response => {
                        if (response == "email_valid") {
                            fetch("?ajax=contact-controller&action=add-contact", option).then(response => response.json()).then(response => {
                                if (response === "message_error") {
                                    console.log("Une erreur est subvenue lors de l'envoi. Veuillez ressayer plus tard!!");
                                } else {
                                    window.location.href = response;
                                }
                            })
                        }
                        else {
                            console.log("Email n'est pas valide!!!");
                        }
                    })
                } else {
                    console.log("Remplissez tous les champs!!!");
                }
            })
        }
        else {
            console.log("Remplissez tous les champs!!");
        }
    })
})