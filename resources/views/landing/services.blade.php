@extends('layouts.landing')
@section('title', 'Our Services – Digital Pulse')
@section('content')
        <section class="service-section">
        <div class="service-container">
            <h1>Our Services</h1>
            <p class="service-subtitle">Add and manage the services we offer, instantly.</p>

            <form id="serviceForm" class="service-form">
                <input type="text" id="serviceTitle" placeholder="Service Title" required />
                <textarea id="serviceDesc" rows="3" placeholder="Service Description" required></textarea>
                <button type="submit" class="cta-btn">Add Service</button>
            </form>

            <div id="serviceCards" class="service-cards"></div>
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
