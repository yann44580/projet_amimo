window.onload = () => {
    const FiltersForm = document.querySelector("#filters");
        // On boucle sur les inputs
    document.querySelectorAll("#filters input").forEach(input => {
        input.addEventListener("change", () => {
            // Ici on intercepte les clics
            // on récupére les données du formulaire
            const Form = new FormData(FiltersForm); 

            // On fabrique la "querystring"
            const Params = new URLSearchParams();

            Form.forEach((value, key) =>{
                Params.append(key, value);
            });

            // on crée l'URL active
            const url = new URL(window.location.href);
            
            // on crée la requete ajax
            fetch(url.pathname + "?" + Params.toString() + "&ajax=1", {
                headers : {
                    "X-Requested-With" : "XMLHttpRequest"
                }
            }).then(response => response.json()
            ).then(data => {
                const content = document.querySelector('#content');
                content.innerHTML = data.content;
            }).catch(e => console.error);
        });
    });
}