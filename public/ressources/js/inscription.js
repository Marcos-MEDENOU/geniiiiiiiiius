let validation = document.getElementById("validation_inscription");

document.addEventListener("DOMContentLoaded", () => {
validation.addEventListener("click", (e) => {
    e.preventDefault();
    let email = document.getElementById("email").value;
    let pseudo = document.getElementById("lastName").value;
    let password = document.getElementById("password").value;
    let confirm = document.getElementById("c_password").value;
    if((email !== "") && (pseudo !== "") && (password !== "") && (confirm !== ""))
    {
        if(password === confirm)
        {
            let data = {
                email: email,
                pseudo: pseudo,
                password: password,
                confirm: confirm
            }
            data = JSON.stringify(data);
            let option = {
                header: {
                    content: "application/json"
                },
                body: data,
                method: "post"
            }
            fetch("?ajax=user-controller&action=verify-inputs", option).then(response => response.json()).then(response  => {
                if(response == "valid_input")
                {
                    fetch("?ajax=user-controller&action=verify-email", option).then(response => response.json()).then(response  => {
                        if(response == "email_valid")
                        {
                            fetch("?ajax=user-controller&action=verify-password", option).then(response => response.json()).then(response  => {
                                if(response == "password_identique")
                                {
                                    fetch("?ajax=user-controller&action=pass-word", option).then(response => response.json()).then(response  => {
                                        if(response == "password_respect")
                                        {
                                            fetch("/?ajax=user-controller&action=register", option).then(response => response.json()).then(response  => {
                                                if(response == "bad")
                                                {
                                                    console.log("User existe");
                                                } else {
                                                    window.location.href = response;
                                                }
                                            })
                                        } else
                                        {
                                            console.log("Le mot de passe ne respect le format pré-définis!!");
                                        }
                                    })
                                } else {
                                    console.log("Les mots de passe ne sont pas conformes!!");
                                }
                            })
                        } else {
                            console.log("L'email n'est pas correct!!");
                        }
                    })
                } else {
                    console.log("Remplissez tous les champs!!");
                }
                
            });
        } else {
            console.log("Les mots de passe ne sont pas conformes !!");
        }
    } else {
        console.log("Remplissez tous les champs !!");
    }
})
})