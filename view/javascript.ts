document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById('reclamation-form');
    const typeField = document.getElementById('type');
    const progressBar = document.getElementById('progress-bar');

    // Mise à jour des champs dynamiques
    typeField.addEventListener('change', () => {
        const selectedValue = typeField.value;

        document.querySelectorAll('.dynamic-field').forEach(field => {
            field.classList.remove('active');
        });

        if (selectedValue === 'cours') {
            document.getElementById('cours-details').classList.add('active');
        } else if (selectedValue === 'paiement') {
            document.getElementById('paiement-details').classList.add('active');
        }
    });

    // Mise à jour de la barre de progression
    form.addEventListener('input', () => {
        const totalFields = form.elements.length;
        const filledFields = [...form.elements].filter(el => el.value).length;
        const progress = Math.round((filledFields / totalFields) * 100);
        progressBar.style.width = `${progress}%`;
    });
});
