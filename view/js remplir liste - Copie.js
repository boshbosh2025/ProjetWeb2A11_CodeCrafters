// URL du fichier PHP
const url = 'http://localhost/reclamations.php';

// Récupération des données dynamiques
fetch(url)
    .then(response => response.json())
    .then(data => {
        const list = document.getElementById('reclamation-list');

        // Parcourir les réclamations et générer les boutons dynamiquement
        data.forEach(item => {
            const li = document.createElement('li');
            li.innerHTML = `
                <button 
                    class="reclamation-btn" 
                    data-name="${item.nom_complet}" 
                    data-id="${item.id}"
                    data-email="${item.email}" 
                    data-message="${item.description}">
                    ${item.nom_complet}
                </button>
            `;
            list.appendChild(li);
        });

        // Réattacher les événements une fois la liste remplie
        attachReclamationEvents();
    })
    .catch(error => console.error('Erreur lors du chargement des réclamations :', error));

// Fonction pour attacher les événements de clic
function attachReclamationEvents() {
    const reclamationBtns = document.querySelectorAll('.reclamation-btn');
    const previewSection = document.getElementById('preview');
    const previewName = document.getElementById('preview-name');
    const previewEmail = document.getElementById('preview-email');
    const previewMessage = document.getElementById('preview-message');

    reclamationBtns.forEach((btn) => {
        btn.addEventListener('click', () => {
            const name = btn.getAttribute('data-name');
            const email = btn.getAttribute('data-email');
            const message = btn.getAttribute('data-message');

            previewName.textContent = name;
            previewEmail.textContent = email;
            previewMessage.textContent = message;

            previewSection.style.display = 'block';
        });
    });
}
