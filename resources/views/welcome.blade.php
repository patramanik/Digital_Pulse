@extends('layouts.landing')
@section('title', 'Digital Pulse – Home')
@section('content')
    <section class="hero-section">
        <div class="hero-content">
            <h1>We Drive Digital Growth</h1>
            <p>Welcome to Digital Pulse – your partner for online dominance and brand authority.</p>
            <a href="services.html" class="cta-btn">Explore Services</a>
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
