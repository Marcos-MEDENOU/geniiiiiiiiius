let adresse_ip = document.getElementById("adresse_ip").value;
    let data = {
        adresse: adresse_ip
    };
    data = JSON.stringify(data);
    let option = {
        header: {
            content: "application/json"
        },
        body: data,
        method: "post"
    };
    fetch("?ajax=contact-controller&action=insert-ip", option);