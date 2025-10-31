@extends('layouts.master')

@section('title', 'Test Create')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Select Class & Subject to View Quizzes</h2>

    <div class="row mb-4">
        <div class="col-md-3">
            <label for="class_id" class="form-label">Select Class</label>
            <select id="class_id" class="form-control">
                <option value="">-- Select Class --</option>
                @foreach ($classes as $class)
                    <option value="{{ $class->id }}">{{ $class->class_name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <label for="subject_id" class="form-label">Select Subject</label>
            <select id="subject_id" class="form-control" disabled>
                <option value="">-- Select Subject --</option>
            </select>
        </div>

        <div class="col-md-3">
            <label for="level_filter" class="form-label">Filter by Level</label>
            <select id="level_filter" class="form-control">
                <option value="">All Levels</option>
                <option value="easy">Easy</option>
                <option value="medium">Medium</option>
                <option value="hard">Hard</option>
            </select>
        </div>

        <div class="col-md-3 d-flex align-items-end">
            <button id="scheduleTestBtn" class="btn btn-success w-100">Create Set</button>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped" id="quizTable">
            <thead class="table-primary">
                <tr>
                    <th><input type="checkbox" id="selectAll"></th>
                    <th>#</th>
                    <th>Class</th>
                    <th>Subject</th>
                    <th>Question</th>
                    <th>Options</th>
                    <th>Correct Answer</th>
                    <th>Explanation</th>
                    <th>Level</th>
                </tr>
            </thead>
            <tbody id="quizTableBody">
                <!-- Quizzes will be loaded here -->
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const classSelect = document.getElementById('class_id');
    const subjectSelect = document.getElementById('subject_id');
    const levelFilter = document.getElementById('level_filter');
    const tableBody = document.getElementById('quizTableBody');
    const selectAllCheckbox = document.getElementById('selectAll');
    const scheduleBtn = document.getElementById('scheduleTestBtn');
    const form = document.getElementById('scheduleTestForm');

    let allQuizzes = [];

    // Load subjects by class
    classSelect.addEventListener('change', () => {
        const classId = classSelect.value;
        subjectSelect.innerHTML = '<option value="">Loading...</option>';
        subjectSelect.disabled = true;

        if (!classId) {
            subjectSelect.innerHTML = '<option value="">-- Select Subject --</option>';
            subjectSelect.disabled = true;
            tableBody.innerHTML = '';
            allQuizzes = [];
            return;
        }

        fetch(`/admin/get-subjects/${classId}`)
            .then(res => res.json())
            .then(subjects => {
                subjectSelect.innerHTML = '<option value="">-- Select Subject --</option>';
                subjects.forEach(sub => {
                    const option = document.createElement('option');
                    option.value = sub.id;
                    option.textContent = sub.subject_name;
                    subjectSelect.appendChild(option);
                });
                subjectSelect.disabled = false;
            });
    });

    // Load quizzes when subject changes
    subjectSelect.addEventListener('change', () => {
        const classId = classSelect.value;
        const subjectId = subjectSelect.value;
        if (!classId || !subjectId) return;

        fetch(`{{ route('get.quizzes.by.class') }}?class_id=${classId}&subject_id=${subjectId}`)
            .then(res => res.json())
            .then(quizzes => {
                allQuizzes = quizzes;
                renderQuizzes(quizzes);
            });
    });

    // Filter quizzes by level
    levelFilter.addEventListener('change', () => {
        const level = levelFilter.value;
        const filtered = level ? allQuizzes.filter(q => q.level === level) : allQuizzes;
        renderQuizzes(filtered);
    });

    // Render quizzes
    function renderQuizzes(quizzes) {
        tableBody.innerHTML = '';
        quizzes.forEach((quiz, i) => {
            const tr = document.createElement('tr');
            tr.innerHTML = `
                <td><input type="checkbox" name="quiz_ids[]" value="${quiz.id}" class="quizCheckbox"></td>
                <td>${i + 1}</td>
                <td>${quiz.class_subject.class.class_name}</td>
                <td>${quiz.class_subject.subject.subject_name}</td>
                <td>${quiz.question}</td>
                <td><ul>${quiz.formatted_options.map(o => `<li>${o}</li>`).join('')}</ul></td>
                <td>${quiz.formatted_options[quiz.corr_ans - 1] ?? 'N/A'}</td>
                <td>${quiz.expl ?? '-'}</td>
                <td>${quiz.level}</td>
            `;
            tableBody.appendChild(tr);
        });
        selectAllCheckbox.checked = false;
    }

    // Select all checkboxes
    selectAllCheckbox.addEventListener('change', () => {
        document.querySelectorAll('.quizCheckbox').forEach(cb => cb.checked = selectAllCheckbox.checked);
    });

    // 🔥 Create Set button
   scheduleBtn.addEventListener('click', async (e) => {
    e.preventDefault();

    const selected = Array.from(document.querySelectorAll('.quizCheckbox:checked')).map(cb => cb.value);
    const classId = document.getElementById('class_id').value;
    const subjectId = document.getElementById('subject_id').value;

    if (!classId || !subjectId) {
        Swal.fire('Warning', 'Please select class and subject.', 'warning');
        return;
    }

    if (selected.length === 0) {
        Swal.fire('Warning', 'Please select at least one quiz.', 'warning');
        return;
    }

    // ✅ Ask user for custom title using SweetAlert input
    const { value: title } = await Swal.fire({
        title: 'Enter Test Title',
        input: 'text',
        inputPlaceholder: 'e.g., Mathematics Chapter 1 Test',
        showCancelButton: true,
        confirmButtonText: 'Create',
        cancelButtonText: 'Cancel',
        inputValidator: (value) => {
            if (!value) {
                return 'Please enter a title!';
            }
        }
    });

    if (!title) return; // User cancelled or left blank

    // ✅ Proceed with AJAX request
    fetch(`{{ route('schedule.test') }}`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            title: title,
            quiz_ids: selected,
            class_id: classId,
            subject_id: subjectId
        })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            Swal.fire('Success', data.success, 'success');
        } else {
            Swal.fire('Error', data.message || 'Something went wrong', 'error');
        }
    })
    .catch(err => {
        console.error(err);
        Swal.fire('Error', 'Failed to create test set', 'error');
    });
});

});
</script>


@endsection
