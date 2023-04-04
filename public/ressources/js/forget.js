let v_email = document.getElementById("validation_email");
let v_pass = document.getElementById("validation_password");
let code = document.getElementById("code");
let pwd = document.getElementById("pwd");
let idemail = document.getElementById("email");

document.addEventListener("DOMContentLoaded", () => {
    code.style = "display:none";
    pwd.style = "display:none";

    v_email.addEventListener("click", (e) => {
        let email = document.getElementById("useremail").value;
        e.preventDefault();
        if (email !== "") {
            let data = {
                email: email
            }
            data = JSON.stringify(data);
            let option = {
                header: {
                    content: "application/json"
                },
                body: data,
                method: "post"
            };
            fetch("?ajax=forget-controller&action=verify-email-inputs", option).then(response => response.json()).then(response => {
                if (response == "valid_email_input") {
                    fetch("?ajax=forget-controller&action=verify-email", option).then(response => response.json()).then(response => {
                        if (response == "email_valid") {
                            fetch("?ajax=forget-controller&action=update", option).then(response => response.json()).then(response => {
                                if (response === null) {
                                    idemail.style = "display:none";
                                    code.style = "display:block";
                                }
                                else {
                                    console.log("Une erreur est subvenue, veuilez réessayer!!");
                                }
                            })
                        } else {
                            console.log("Le format de l'email n'est requise !!");
                        }
                    })
                } else {
                    console.log("Remplissez le champs!!!");
                }
            })
        } else {
            console.log("Veuillez bien remplir le champs!!!");
        }
    })

    let code_email = document.getElementById("email_code");
    code_email.addEventListener("keyup", (e) => {
        let email = document.getElementById("useremail").value;
        let email_code = document.getElementById("email_code").value
        if (email_code.trim() !== "") {
            let data = {
                email: email,
                email_code: email_code
            }
            data = JSON.stringify(data);
            let option = {
                header: {
                    content: "application/json"
                },
                body: data,
                method: "post"
            }
            fetch("?ajax=forget-controller&action=code-email", option).then(response => response.json()).then(response => {
                if (response === "good") {
                    code.style = "display:none";
                    pwd.style = "display:block";
                } else {
                    console.log("Le code n'est pas correct!!!");
                }
            })
        }
    })

    v_pass.addEventListener("click", (e) => {
        e.preventDefault();
        let pass = document.getElementById("mdp").value;
        let new_pass = document.getElementById("new_mdp").value;
        let email = document.getElementById("useremail").value;
        if ((pass !== "") && (new_pass !== "")) {
            let data = {
                email: email,
                pass: pass,
                new_pass: new_pass
            }
            data = JSON.stringify(data);
            let option = {
                header: {
                    content: "application/json"
                },
                body: data,
                method: "post"
            }
            fetch("?ajax=forget-controller&action=new-empty-pass", option).then(response => response.json()).then(response => {
                if (response === "valid_input") {
                    fetch("?ajax=forget-controller&action=verify-pass-word", option).then(response => response.json()).then(response => {
                        if (response === "password_identique") {
                            fetch("?ajax=forget-controller&action=pass-word", option).then(response => response.json()).then(response => {
                                if (response === "password_respect") {
                                    fetch("?ajax=forget-controller&action=update-pass", option).then(response => response.json()).then(response => {
                                        if (response === "bad") {
                                            console.log("Une erreur est subvenue lors de l'éxécution. Veuillez essayer plus!!!");
                                        } else {
                                            window.location.href = response;
                                        }
                                    })
                                } else {
                                    console.log("Le format du mot de passe n'est pas celui requis!!!");
                                }
                            })
                        } else {
                            console.log("Les mots de passe ne sont pas identiques!!!");
                        }
                    })
                } else {
                    console.log("Remplissez tous les champs!!!");
                }
            })
        } else {
            console.log("Remplissez tous les champs!!");
        }
    })
})