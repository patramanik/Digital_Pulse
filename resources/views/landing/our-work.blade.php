@extends('layouts.landing')
@section('title', 'Our Work – Digital Pulse')
@section('content')
<section class="work-section">
        <div class="work-container">
            <h1>Our Work</h1>
            <p class="work-subtitle">Discover our latest projects and case studies.</p>

            <form id="workForm" class="work-form">
                <input type="text" id="projectTitle" placeholder="Project Title" required />
                <textarea id="projectDesc" rows="3" placeholder="Project Description" required></textarea>
                <button type="submit" class="cta-btn">Add Project</button>
            </form>

            <div id="workCards" class="work-cards"></div>
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
