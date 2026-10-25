import './bootstrap';

// Keep modals outside animated containers so Bootstrap's body-level backdrop cannot cover them.
document.querySelectorAll('.modal').forEach((modal) => {
    if (modal.parentElement !== document.body) {
        document.body.append(modal);
    }
});
