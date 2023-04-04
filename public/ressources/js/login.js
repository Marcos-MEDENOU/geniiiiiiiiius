let validation = document.getElementById("validation_connexion");

document.addEventListener("DOMContentLoaded", () => {
validation.addEventListener("click", (e) => {
    e.preventDefault();
    let username = document.getElementById("username").value;
    let pass = document.getElementById("pass").value;

    if((username !== "") && (pass !== ""))
    {
            let data = {
                username: username,
                pass: pass
            }
            data = JSON.stringify(data);
            let option = {
                header: {
                    content: "application/json"
                },
                body: data,
                method: "post"
            }
            fetch("?ajax=login-controller&action=verify-inputs", option).then(response => response.json()).then(response  => {
                if(response == "valid_input")
                {
                    fetch("?ajax=login-controller&action=verify-account", option).then(response => response.json()).then(response  => {
                        if(response == "mot_passe_erroné")
                        {
                            console.log("Le mot de passe ne correspond pas!!");
                        }
                        else if(response == "User_not_exist")
                        {
                            console.log("L'utilisateur n'existe pas!!");
                        }
                        else {
                            window.location.href = response;
                        }
                    })
                } else {
                    console.log("Remplissez tous les champs");
                }
            })
    } else {
        console.log("Remplissez tous les champs!!");
    }
})
})