const typeField = document.getElementById('type');
const dynamicFields = document.getElementById('dynamic-fields');
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

// Barre de progression
document.getElementById('reclamation-form').addEventListener('input', () => {
    const totalFields = document.querySelectorAll('input, textarea, select').length;
    const filledFields = Array.from(document.querySelectorAll('input, textarea, select')).filter(input => input.value.trim() !== '').length;
    const progressPercentage = (filledFields / totalFields) * 100;

    progressBar.style.width = `${progressPercentage}%`;
});