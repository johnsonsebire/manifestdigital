<x-layouts.frontend title="Book a Call - Schedule Your Free Consultation" :transparent-header="false" preloader='advanced'>

    @push('styles')
        @vite(['resources/css/book-a-call.css'])
    @endpush

    <x-booking.hero />
    <x-booking.benefits-section />
    <x-booking.meeting-types />

    <x-booking.form-section />

    <x-booking.faq-section />

    <x-booking.contact-alternatives />


    @push('scripts')
        <script>
            // ========================
            // Meeting Type Selection
            // ========================
            const meetingCards = document.querySelectorAll('.meeting-card');
            const meetingTypeSelect = document.getElementById('meetingType');

            meetingCards.forEach(card => {
                card.addEventListener('click', function() {
                    // Remove selected class from all cards
                    meetingCards.forEach(c => c.classList.remove('selected'));

                    // Add selected class to clicked card
                    this.classList.add('selected');

                    // Get meeting type
                    const meetingType = this.getAttribute('data-calendly');

                    // Update form select value
                    if (meetingTypeSelect) {
                        meetingTypeSelect.value = meetingType;
                    }

                    // Scroll to calendar
                    document.getElementById('calendar').scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                });
            });

            // ========================
            // Booking Form Submission
            // ========================
            const bookingForm = document.getElementById('bookingForm');
            const successMessage = document.getElementById('successMessage');

            // Set minimum date to today
            const preferredDateInput = document.getElementById('preferredDate');
            if (preferredDateInput) {
                const today = new Date().toISOString().split('T')[0];
                preferredDateInput.setAttribute('min', today);
            }

            if (bookingForm) {
                bookingForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    // Get form data
                    const formData = new FormData(bookingForm);
                    const data = Object.fromEntries(formData);

                    // Here you would normally send the data to your backend
                    // For now, we'll simulate a successful submission
                    console.log('Booking request:', data);

                    // Show success message
                    bookingForm.style.display = 'none';
                    successMessage.classList.add('show');

                    // Scroll to success message
                    successMessage.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });

                    // You can also send an email notification here
                    // Example using mailto (opens default email client):
                    const emailBody = `
New Consultation Request:

Name: ${data.firstName} ${data.lastName}
Email: ${data.email}
Phone: ${data.phone}
Meeting Type: ${data.meetingType}
Preferred Date: ${data.preferredDate}
Preferred Time: ${data.preferredTime}
Timezone: ${data.timezone}
Project Details: ${data.projectDetails || 'Not provided'}
                `.trim();

                    // Optional: Auto-send email (opens mail client)
                    // window.location.href = `mailto:business@manifestghana.com?subject=New Consultation Request&body=${encodeURIComponent(emailBody)}`;

                    // Reset form after 3 seconds
                    setTimeout(() => {
                        bookingForm.reset();
                        bookingForm.style.display = 'block';
                        successMessage.classList.remove('show');
                    }, 5000);
                });
            }

            // ========================
            // FAQ Accordion
            // ========================
            const faqItems = document.querySelectorAll('.faq-item');

            faqItems.forEach(item => {
                const question = item.querySelector('.faq-question');

                question.addEventListener('click', () => {
                    // Close other items
                    faqItems.forEach(otherItem => {
                        if (otherItem !== item) {
                            otherItem.classList.remove('active');
                        }
                    });

                    // Toggle current item
                    item.classList.toggle('active');
                });
            });
        </script>
    @endpush


</x-layouts.frontend>
