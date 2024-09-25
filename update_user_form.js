// Fetch user data from URL query params and load it into the form
function getQueryParams() {
    const params = new URLSearchParams(window.location.search);
    return {
        user: params.get('user') // Assuming 'user' is a unique identifier like a username or user ID
    };
}

// Fetch and populate user data when the page loads
window.onload = function () {
    const { user } = getQueryParams();
    if (user) {
        // Replace this with an actual API endpoint that fetches the user data
        fetch(`/getUser?user=${user}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('firstName').value = data.firstName;
                document.getElementById('lastName').value = data.lastName;
                document.getElementById('address').value = data.address;
                document.getElementById('dob').value = data.dob;
                document.getElementById('password').value = data.password;
                document.getElementById('position').value = data.position;
                document.getElementById('expiryPassword').value = data.expiryPassword;
            })
            .catch(error => console.error('Error:', error));
    }
};

// Handle form submission
document.getElementById('updateForm').addEventListener('submit', function (event) {
    event.preventDefault(); // Prevent default form submission

    const formData = new FormData(this); // Collect all form data

    // Send the update request to the backend
    fetch('/updateUser', {
        method: 'POST',
        body: formData
    })
        .then(response => {
            if (response.ok) {
                // On success, redirect to the view users page
                window.location.href = '/viewUsers';
            } else {
                alert('Failed to update user');
            }
        })
        .catch(error => console.error('Error:', error));
});