
// Toggle sidebar on mobile
document.getElementById('sidebarToggle').addEventListener('click', function() {
    document.getElementById('sidebar').classList.toggle('show');
    document.getElementById('content').classList.toggle('sidebar-open');
});

// Initialize all Bootstrap tooltips
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
    return new bootstrap.Tooltip(tooltipTriggerEl)
});

// Example function to add coauthor (just for UI demonstration)
document.getElementById('addCoauthorBtn').addEventListener('click', function() {
    const email = document.getElementById('coauthorEmail').value;
    if(email) {
        const coautorList = document.querySelector('.coauthor-list');
        const newCoautor = document.createElement('div');
        newCoautor.className = 'coauthor-item d-flex justify-content-between align-items-center';
        newCoautor.innerHTML = `
            <span>${email}</span>
            <button type="button" class="btn btn-sm btn-outline-danger">
                <i class="fas fa-times"></i>
            </button>
        `;
        coautorList.appendChild(newCoautor);
        document.getElementById('coauthorEmail').value = '';
        
        // Add event listener to the newly created remove button
        newCoautor.querySelector('button').addEventListener('click', function() {
            newCoautor.remove();
        });
    }
});

// Add event listeners to existing remove buttons
document.querySelectorAll('.coauthor-item button').forEach(button => {
    button.addEventListener('click', function() {
        this.closest('.coauthor-item').remove();
    });
});
