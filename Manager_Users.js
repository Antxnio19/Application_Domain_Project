document.addEventListener('DOMContentLoaded', () => {
    const approveChecks = document.querySelectorAll('.approve-check');
    const statusCells = document.querySelectorAll('.status');
    const suspendBtns = document.querySelectorAll('.suspend-btn');
    const suspendModal = document.getElementById('suspend-modal');
    const closeBtn = document.querySelector('.close-btn');
    const confirmSuspendBtn = document.getElementById('confirm-suspend');
    const suspendDurationInput = document.getElementById('suspend-duration');
    let selectedRow;

    // Update status based on approval checkmark change
    approveChecks.forEach((check, index) => {
        check.addEventListener('change', () => {
            const statusCell = statusCells[index];
            const username = statusCell.closest('tr').querySelector('td:nth-child(3)').textContent;

            if (check.checked) {
                statusCell.textContent = 'Yes';
                updateUserStatus(username, true); // Call backend to update status to active
            } else {
                statusCell.textContent = 'No';
                updateUserStatus(username, false); // Call backend to deactivate user
            }
        });
    });

    // Show suspend modal when suspend button is clicked
    suspendBtns.forEach(btn => {
        btn.addEventListener('click', (event) => {
            selectedRow = event.target.closest('tr');
            suspendModal.style.display = 'block';
        });
    });

    // Close modal when close button is clicked
    closeBtn.addEventListener('click', () => {
        suspendModal.style.display = 'none';
    });

    window.addEventListener('click', (event) => {
        if (event.target === suspendModal) {
            suspendModal.style.display = 'none';
        }
    });

    // Confirm suspend action
    confirmSuspendBtn.addEventListener('click', () => {
        const suspendDuration = suspendDurationInput.value;
        if (suspendDuration) {
            const username = selectedRow.querySelector('td:nth-child(3)').textContent;

            // Update row UI
            const statusCell = selectedRow.querySelector('.status');
            statusCell.textContent = 'No'; // Deactivate user in UI
            const checkCell = selectedRow.querySelector('.approve-check');
            checkCell.checked = true;

            // Call the backend to suspend the user
            suspendUser(username, suspendDuration);

            alert(`User suspended for ${suspendDuration} days.`);
            suspendModal.style.display = 'none';
        } else {
            alert('Please enter a duration.');
        }
    });

    // Function to update user's active status in the backend
    function updateUserStatus(username, isActive) {
        fetch('/updateUserStatus', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ username, isActive })
        })
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    alert('Failed to update user status.');
                }
            })
            .catch(error => {
                console.error('Error updating status:', error);
            });
    }

    // Function to suspend a user in the backend
    function suspendUser(username, suspendDuration) {
        fetch('/suspendUser', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ username, suspendDuration })
        })
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    alert('Failed to suspend user.');
                }
            })
            .catch(error => {
                console.error('Error suspending user:', error);
            });
    }
});
