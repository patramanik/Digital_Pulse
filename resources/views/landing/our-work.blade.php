@extends('layouts.landing')
@section('title', 'Our Work – Digital Pulse')
@section('content')
<section class="work-section">
        <div class="work-container">
            <h1>Our Work</h1>
            <p class="work-subtitle">Discover our latest projects and case studies.</p>

            <div class="influencer-cards">

                @if(isset($works) && count($works))
                    @foreach($works as $work)

                    <div class="influencer-card">
                        <h3>{{ $work->work_desc }}</h3>
                        <p>{{ $work->work_desc}}</p>
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

            <!-- <a href="" class="cta-btn">Partner With Us</a> -->
            <!-- <div id="workCards" class="work-cards"></div> -->
        </div>
    </section>
@endsection
@section('scripts')
     <script>
        // Dynamic Work Cards
        const workForm = document.getElementById('workForm');
        const workCards = document.getElementById('workCards');

        function loadWork() {
            const data = JSON.parse(localStorage.getItem('ourWorkData') || '[]');
            workCards.innerHTML = '';
            data.forEach((item, index) => {
                const card = document.createElement('div');
                card.className = 'work-card';
                card.innerHTML = `
          <h3>${item.title}</h3>
          <p>${item.desc}</p>
          <button onclick="removeWork(${index})">🗑 Remove</button>
        `;
                workCards.appendChild(card);
            });
        }

        function removeWork(index) {
            const data = JSON.parse(localStorage.getItem('ourWorkData') || '[]');
            data.splice(index, 1);
            localStorage.setItem('ourWorkData', JSON.stringify(data));
            loadWork();
        }

        workForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const title = document.getElementById('projectTitle').value.trim();
            const desc = document.getElementById('projectDesc').value.trim();

            if (!title || !desc) return;

            const newEntry = { title, desc };
            const currentData = JSON.parse(localStorage.getItem('ourWorkData') || '[]');
            currentData.push(newEntry);
            localStorage.setItem('ourWorkData', JSON.stringify(currentData));

            workForm.reset();
            loadWork();
        });

        window.onload = loadWork;
    </script>
@endsection
