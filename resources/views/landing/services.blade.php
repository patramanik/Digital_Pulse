@extends('layouts.landing')
@section('title', 'Our Services – Digital Pulse')
@section('content')
    <section class="service-section">
        <div class="service-container">
            <h1>Our Services</h1>
            <p class="service-subtitle">Add and manage the services we offer, instantly.</p>

            <div class="influencer-cards">

             @if(isset($services) && count($services))
                @foreach($services as $service)

                <div class="influencer-card">
                    <h3>{{ $service->service_title }}</h3>
                    <p>{{ $service->service_desc}}</p>
                </div>
                @endforeach
            @else
                <p>No services available.</p>
            @endif

                <!-- <div class="influencer-card">
                    <h3>Campaign Management</h3>
                    <p>From influencer discovery to publishing to reporting — we manage everything with precision.</p>
                </div>
                <div class="influencer-card">
                    <h3>Authenticity & ROI</h3>
                    <p>We focus on organic reach, trust-building, and ROI-focused partnerships that convert.</p>
                </div> -->
            </div>
            <a href="/contact" class="cta-btn">Contact With Us</a>
        </div>
    </section>
@endsection
@section('scripts')
      <script>
        const serviceForm = document.getElementById('serviceForm');
        const serviceCards = document.getElementById('serviceCards');

        function loadServices() {
            const data = JSON.parse(localStorage.getItem('ourServiceData') || '[]');
            serviceCards.innerHTML = '';
            data.forEach((item, index) => {
                const card = document.createElement('div');
                card.className = 'service-card';
                card.innerHTML = `
          <h3>${item.title}</h3>
          <p>${item.desc}</p>
          <button onclick="removeService(${index})">🗑 Remove</button>
        `;
                serviceCards.appendChild(card);
            });
        }

        function removeService(index) {
            const data = JSON.parse(localStorage.getItem('ourServiceData') || '[]');
            data.splice(index, 1);
            localStorage.setItem('ourServiceData', JSON.stringify(data));
            loadServices();
        }

        serviceForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const title = document.getElementById('serviceTitle').value.trim();
            const desc = document.getElementById('serviceDesc').value.trim();

            if (!title || !desc) return;

            const newEntry = { title, desc };
            const currentData = JSON.parse(localStorage.getItem('ourServiceData') || '[]');
            currentData.push(newEntry);
            localStorage.setItem('ourServiceData', JSON.stringify(currentData));

            serviceForm.reset();
            loadServices();
        });

        window.onload = loadServices;
    </script>
@endsection
