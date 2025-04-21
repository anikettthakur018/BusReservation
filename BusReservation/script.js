document.addEventListener('DOMContentLoaded', function () {
    const bookingForm = document.getElementById('bookingForm');
    const reservationDetails = document.getElementById('reservationDetails');
    
    // Hide reservation details initially
    reservationDetails.style.display = 'none';

    bookingForm.addEventListener('submit', function (e) {
        e.preventDefault(); // Prevent default form submission

        // Get form values
        const formData = new FormData(bookingForm);

        // Send data to book_ticket.php using AJAX
        fetch('book_ticket.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json()) // Expect JSON response
        .then(data => {
            if (data.success) {
                // Display reservation details
                document.getElementById('displayName').textContent = formData.get('name');
                document.getElementById('displayEmail').textContent = formData.get('email');
                document.getElementById('displayFrom').textContent = formData.get('from');
                document.getElementById('displayTo').textContent = formData.get('to');
                document.getElementById('displayDate').textContent = formatDate(formData.get('date'));
                document.getElementById('displayTime').textContent = formData.get('time');

                // Show reservation details permanently
                reservationDetails.style.display = 'block';

                // Show success message
                let successMessage = document.getElementById('successMessage');
                if (!successMessage) {
                    successMessage = document.createElement('p');
                    successMessage.id = "successMessage";
                    successMessage.textContent = "✅ Ticket booked successfully!";
                    successMessage.style.color = "green";
                    successMessage.style.fontWeight = "bold";
                    reservationDetails.appendChild(successMessage);
                }

                // Scroll to reservation details smoothly
                reservationDetails.scrollIntoView({ behavior: 'smooth' });

                // Clear the form
                bookingForm.reset();
            } else {
                alert("⚠️ Booking failed! " + data.message);
            }
        })
        .catch(error => console.error("Error:", error));
    });

    // Function to format date for display
    function formatDate(dateString) {
        const options = { year: 'numeric', month: 'long', day: 'numeric' };
        const date = new Date(dateString);
        return date.toLocaleDateString('en-US', options);
    }

    // Simple validation: "From" and "To" locations must be different
    const fromSelect = document.getElementById('from');
    const toSelect = document.getElementById('to');

    function validateLocations() {
        if (fromSelect.value && fromSelect.value === toSelect.value) {
            toSelect.setCustomValidity('Destination must be different from departure');
        } else {
            toSelect.setCustomValidity('');
        }
    }

    fromSelect.addEventListener('change', validateLocations);
    toSelect.addEventListener('change', validateLocations);

    // Date validation: prevent selecting past dates
    const dateInput = document.getElementById('date');
    const today = new Date().toISOString().split('T')[0];
    dateInput.setAttribute('min', today);
});
