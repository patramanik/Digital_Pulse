@extends('layouts.landing')
@section('title', 'Careers – Digital Pulse')
@section('content')
<section class="career-section">
        <div class="career-container">
            <h1>Join Our Team</h1>
            <p class="career-subtitle">Post and manage job openings anytime.</p>

            <!-- <form id="jobForm" class="career-form">
                <input type="text" id="jobTitle" placeholder="Job Title" required />
                <textarea id="jobDesc" rows="3" placeholder="Job Description" required></textarea>
                <button type="submit" class="cta-btn">Post Job</button>
            </form> -->
            <div class="influencer-cards">

             @if(isset($careers) && count($careers))
                @foreach($careers as $career)

                <div class="influencer-card">
                    <h3>{{ $career->career_title }}</h3>
                    <p>{{ $career->career_desc}}</p>
                </div>
                @endforeach
            @else
                <p>No job openings available.</p>
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

            <div id="jobCards" class="career-cards"></div>
        </div>
    </section>
@endsection
@section('scripts')
<script>
        const jobForm = document.getElementById('jobForm');
        const jobCards = document.getElementById('jobCards');

        function loadJobs() {
            const data = JSON.parse(localStorage.getItem('careerData') || '[]');
            jobCards.innerHTML = '';
            data.forEach((item, index) => {
                const card = document.createElement('div');
                card.className = 'career-card';
                card.innerHTML = `
          <h3>${item.title}</h3>
          <p>${item.desc}</p>
          <button onclick="removeJob(${index})">🗑 Remove</button>
        `;
                jobCards.appendChild(card);
            });
        }

        function removeJob(index) {
            const data = JSON.parse(localStorage.getItem('careerData') || '[]');
            data.splice(index, 1);
            localStorage.setItem('careerData', JSON.stringify(data));
            loadJobs();
        }

        jobForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const title = document.getElementById('jobTitle').value.trim();
            const desc = document.getElementById('jobDesc').value.trim();

            if (!title || !desc) return;

            const newJob = { title, desc };
            const currentData = JSON.parse(localStorage.getItem('careerData') || '[]');
            currentData.push(newJob);
            localStorage.setItem('careerData', JSON.stringify(currentData));

            jobForm.reset();
            loadJobs();
        });

        window.onload = loadJobs;
    </script>
@endsection
