// public/js/app.js

document.addEventListener("DOMContentLoaded", () => {
    const formAvis = document.getElementById("form-avis");

    if (formAvis) {
        formAvis.addEventListener("submit", (e) => {
            e.preventDefault(); // Bloque le rechargement de la page

            const establishmentId = document.getElementById("establishment_id").value;
            const rating = document.getElementById("rating").value;
            const comment = document.getElementById("comment").value;
            const zoneReponse = document.getElementById("zone-reponse");

            const donneesAvis = {
                establishment_id: establishmentId,
                rating: rating,
                comment: comment
            };

            fetch("ajouter_avis.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(donneesAvis)
            })
            .then(reponse => {
                if (!reponse.ok) throw new Error("Erreur serveur");
                return reponse.json();
            })
            .then(data => {
                if (data.status === "success") {
                    zoneReponse.innerHTML = `<p style="color: green; font-weight: bold;">${data.message}</p>`;
                    formAvis.reset();
                } else {
                    zoneReponse.innerHTML = `<p style="color: red; font-weight: bold;">${data.message}</p>`;
                }
            })
            .catch(erreur => {
                console.error("Erreur de communication :", erreur);
                zoneReponse.innerHTML = `<p style="color: red;">Erreur réseau locale.</p>`;
            });
        });
    }
});