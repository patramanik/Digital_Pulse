@extends('layouts.master')
@section('title', 'Quiz Entry | Quiz Admin')

@section('content')
    <div class="container py-5">
        <div class="card shadow-lg border-0">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Question Entry</h4>
            </div>
            <div class="card-body">
                <form id="questionForm">
                    @csrf

                    <!-- Class Selection -->
                    <div class="mb-3">
                        <label for="class_id" class="form-label">Class <span class="text-danger">*</span></label>
                        <select name="class_id" id="class_id" class="form-select w-auto" required>
                            <option value="">Select Class</option>
                            @foreach ($classes as $class)
                                <option value="{{ $class->id }}">{{ $class->class_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Subject Selection -->
                    <div class="mb-3">
                        <label for="subject_id" class="form-label">Subject <span class="text-danger">*</span></label>
                        <select name="subject_id" id="subject_id" class="form-select w-auto" required>
                            <option value="">Select Subject</option>
                        </select>
                    </div>


                    <!-- Question -->
                    <div class="mb-3">
                        <label for="question" class="form-label">Question <span class="text-danger">*</span></label>
                        <input type="text" id="question" name="question" class="form-control"
                            placeholder="Enter your question" required>
                    </div>

                    <!-- Options -->
                    <div id="options-container" class="mb-3">
                        <label class="form-label">Options <span class="text-danger">*</span></label>
                        <div id="options-list">
                            <div class="input-group mb-2">
                                <input type="text" name="options[]" placeholder="Option 1" class="form-control" required>
                            </div>
                            <div class="input-group mb-2">
                                <input type="text" name="options[]" placeholder="Option 2" class="form-control" required>
                            </div>
                        </div>
                        <button type="button" id="addOptionBtn" class="btn btn-success btn-sm" onclick="addOption()">
                            <i class="fas fa-plus"></i> Add Option
                        </button>
                    </div>

                    <!-- Correct Answer -->
                    <div class="mb-3">
                        <label for="correct_answer" class="form-label">Correct Answer <span
                                class="text-danger">*</span></label>
                        <select name="correct_answer" id="correct_answer" class="form-select w-auto" required>
                            <!-- Dynamically filled -->
                        </select>
                    </div>

                    <!-- Level -->
                    <div class="mb-3">
                        <label for="level" class="form-label">Difficulty Level <span class="text-danger">*</span></label>
                        <select name="level" id="level" class="form-select w-auto" required>
                            <option value="">Select Level</option>
                            <option value="easy">Easy</option>
                            <option value="medium">Medium</option>
                            <option value="hard">Hard</option>
                        </select>
                    </div>

                    <!-- Explanation -->
                    <div class="mb-3">
                        <label for="explanation" class="form-label">Explanation</label>
                        <textarea id="explanation" name="explanation" rows="4" class="form-control"
                            placeholder="Explain why this is the correct answer..."></textarea>
                    </div>

                    <!-- Submit -->
                    <div>
                        <button type="submit" class="btn btn-primary w-100">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        const MAX_OPTIONS = 6;
        const MIN_OPTIONS = 2;

        function addOption() {
            const optionsList = document.getElementById('options-list');
            const count = optionsList.children.length;

            if (count >= MAX_OPTIONS) return;

            const newOption = document.createElement('div');
            newOption.className = 'input-group mb-2';
            newOption.innerHTML = `
                <input type="text" name="options[]" placeholder="Option ${count + 1}" class="form-control" required>
                <button type="button" class="btn btn-danger" onclick="removeOption(this)">
                    <i class="fas fa-trash-alt"></i>
                </button>
            `;

            optionsList.appendChild(newOption);
            updateCorrectAnswerDropdown();
        }

        function removeOption(button) {
            const optionsList = document.getElementById('options-list');
            if (optionsList.children.length > MIN_OPTIONS) {
                button.parentElement.remove();
                updateOptionPlaceholders();
                updateCorrectAnswerDropdown();
            }
        }

        function updateOptionPlaceholders() {
            const inputs = document.querySelectorAll('#options-list input[name="options[]"]');
            inputs.forEach((input, index) => {
                input.placeholder = `Option ${index + 1}`;
            });
        }

        function updateCorrectAnswerDropdown() {
            const dropdown = document.getElementById('correct_answer');
            const inputs = document.querySelectorAll('#options-list input[name="options[]"]');

            dropdown.innerHTML = '';

            const defaultOption = document.createElement('option');
            defaultOption.value = '';
            defaultOption.textContent = 'Select Option';
            defaultOption.disabled = true;
            defaultOption.selected = true;
            dropdown.appendChild(defaultOption);

            inputs.forEach((input, index) => {
                const opt = document.createElement('option');
                opt.value = index + 1;
                opt.textContent = `Option ${index + 1}`;
                dropdown.appendChild(opt);
            });
        }

        document.addEventListener('DOMContentLoaded', () => {
            updateOptionPlaceholders();
            updateCorrectAnswerDropdown();
        });

        document.getElementById('questionForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const form = e.target;
            const formData = new FormData(form);

            fetch("{{ route('quiz.store') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                    },
                    body: formData,
                })
                .then(response => response.json())
                .then(data => {
                    alert('Question submitted successfully!');
                    form.reset();
                    updateOptionPlaceholders();
                    updateCorrectAnswerDropdown();
                    document.getElementById('correct_answer').selectedIndex = 0;
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to submit question.');
                });
        });
        // Dependent dropdown: Fetch subjects when class changes
        document.getElementById('class_id').addEventListener('change', function() {
            const classId = this.value;
            const subjectDropdown = document.getElementById('subject_id');
            subjectDropdown.innerHTML = '<option value="">Loading...</option>';

            if (classId) {
                fetch(`/admin/get-subjects/${classId}`)
                    .then(response => response.json())
                    .then(subjects => {
                        subjectDropdown.innerHTML = '<option value="">Select Subject</option>';
                        subjects.forEach(subject => {
                            const option = document.createElement('option');
                            option.value = subject.id;
                            option.textContent = subject.subject_name;
                            subjectDropdown.appendChild(option);
                        });
                    })
                    .catch(error => {
                        console.error('Error fetching subjects:', error);
                        subjectDropdown.innerHTML = '<option value="">Error loading subjects</option>';
                    });
            } else {
                subjectDropdown.innerHTML = '<option value="">Select Subject</option>';
            }
        });
    </script>
@endsection
