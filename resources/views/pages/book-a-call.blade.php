<x-layouts.frontend title="Book a Call - Schedule Your Free Consultation" :transparent-header="false" preloader='none'>

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
            // Form now submits to backend via Laravel form builder module
            // The old client-side JavaScript has been removed to allow proper form submission
            
            // Set minimum date to today
            const preferredDateInput = document.getElementById('preferredDate');
            if (preferredDateInput) {
                const today = new Date().toISOString().split('T')[0];
                preferredDateInput.setAttribute('min', today);
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
