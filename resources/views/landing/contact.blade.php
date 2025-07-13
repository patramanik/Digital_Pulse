@extends('layouts.landing')
@section('title', 'Contact Us – Digital Pulse')
@section('content')
<section class="contact-section">
        <div class="contact-container">
            <h1>Let's Talk</h1>
            <p>Fill out the form below and we’ll get back to you within 24 hours.</p>

            <form class="contact-form" onsubmit="handleContactForm(event)">
                <input type="text" placeholder="Your Name" required>
                <input type="email" placeholder="Your Email" required>
                <textarea rows="5" placeholder="Your Message" required></textarea>
                <button type="submit" class="cta-btn">Send Message</button>
                <p id="formResponse" class="response-text"></p>
            </form>
        </div>
    </section>
@endsection
@section('scripts')

@endsection
