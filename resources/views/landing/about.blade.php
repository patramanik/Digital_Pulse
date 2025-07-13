@extends('layouts.landing')
@section('title', 'About Us – Digital Pulse')
@section('content')
    <section class="about-section">
        <div class="about-container">
            <h1>About Us</h1>
            <p class="about-tagline">Creative. Data-Driven. Results Obsessed.</p>

            <div class="about-grid">
                <div class="about-left">
                    <h2>Who We Are</h2>
                    <p>Digital Pulse is a full-stack digital marketing agency focused on building lasting brand
                        experiences. Since our inception, we’ve worked with startups and global enterprises to redefine
                        how brands connect with audiences in the digital age.</p>

                    <h2>Our Mission</h2>
                    <p>To empower businesses by delivering transparent, ethical, and ROI-driven digital growth
                        solutions.</p>
                </div>

                <div class="about-right">
                    <h2>Why Choose Us</h2>
                    <ul>
                        <li>✓ Strategic digital roadmaps</li>
                        <li>✓ In-house creative & media teams</li>
                        <li>✓ Transparent analytics and reports</li>
                        <li>✓ 24/7 client communication</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
<script>
    // Highlight current menu link
    const links = document.querySelectorAll(".nav-links a");
    const currentPath = window.location.pathname.split("/").pop();

    links.forEach(link => {
        const href = link.getAttribute("href");
        if (href === currentPath || (href === "index.html" && currentPath === "")) {
            link.classList.add("active-link");
        } else {
            link.classList.remove("active-link");
        }
    });
</script>
@endsection
