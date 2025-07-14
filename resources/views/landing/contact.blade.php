@extends('layouts.landing')
@section('title', 'Contact Us – Digital Pulse')
@section('content')
<section class="contact-section">
    <div class="contact-container">
        <h1>Let's Talk</h1>
        <p>Fill out the form below and we’ll get back to you within 24 hours.</p>
        <form id="contactForm" action="{{ route('landing.contacts.store') }}" method="POST" class="contact-form">
            @csrf
            <input type="text" name="full_name" placeholder="Your Name" required>
            <input type="email" name="email" placeholder="Your Email" required>
            <textarea name="message" rows="5" placeholder="Your Message" required></textarea>
            <button type="submit" class="cta-btn">Send Message</button>
            <p id="formResponse" class="response-text"></p>
        </form>
    </div>
</section>
@endsection

@section('scripts')
<script>
document.getElementById('contactForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);
    const url = form.action;
    const responseText = document.getElementById('formResponse');

    responseText.textContent = 'Sending...';
    responseText.style.color = 'blue';

    // Disable the button to prevent multiple clicks
    const submitButton = form.querySelector('button[type="submit"]');
    submitButton.disabled = true;

    fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
            'Accept': 'application/json'
        },
        body: formData
    })
    .then(async res => {
        const data = await res.json();
        if (res.ok) {
            alert('Your message has been sent successfully!');
            responseText.textContent = 'Message sent successfully!';
            responseText.style.color = 'green';
            form.reset(); // Clear form fields
        } else {
            responseText.textContent = data.message || 'Submission failed.';
            responseText.style.color = 'red';
            alert('Error: ' + (data.message || 'Something went wrong.'));
        }
    })
    .catch(() => {
        responseText.textContent = 'An unexpected error occurred. Please try again.';
        responseText.style.color = 'red';
        alert('An unexpected error occurred.');
    })
    .finally(() => {
        submitButton.disabled = false; // Re-enable the button
    });
});
</script>
@endsection


