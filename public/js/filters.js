window.onload = () => {
    const FiltersForm = document.querySelector("#filters");
        // On boucle sur les inputs
    document.querySelectorAll("#filters input").forEach(input => {
        input.addEventListener("change", () => {
            // Ici on intercepte les clics
            // on récupére les données du formulaire
            const Form = new FormData(FiltersForm); 

            // On fabrique l'url
            const Params = new URLSearchParams();

            Form.forEach((value, key) =>{
                Params.append(key, value);
                console.log(Params.toString())
            })
        });
    });
}