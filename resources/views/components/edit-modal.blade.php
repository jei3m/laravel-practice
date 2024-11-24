<div id="editmodal" class="modal opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center">
    <div class="editmodal-close modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>
    <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">

        <!-- Add your modal content here -->
        <div class="modal-content py-4 text-left px-6">
            <div class="flex justify-between items-center pb-3">
                <p class="text-2xl font-bold">Edit note</p>
                <div class="editmodal-close cursor-pointer z-50">
                    <svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                        <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                    </svg>
                </div>
            </div>

            <div class="note-container w-full mx-auto">
                <form id="editNoteForm" method="POST" class="note-form flex flex-col" onsubmit="return validateForm()">
                    
                    @csrf
                    @method('PUT')

                    <div class="form-group mb-4">
                        <label for="author" class="block text-lg font-medium text-gray-700">Author</label>
                        <input type="text" name="author" id="editNoteAuthor" class="w-full form-control p-2 pl-4 text-lg border border-gray-300 rounded focus:outline-none focus:ring focus:border-blue-500">
                    </div>

                    <div class="form-group mb-4">
                        <label for="year" class="block text-lg font-medium text-gray-700">Year</label>
                        <input type="number" name="year" id="editNoteYear" class="w-full form-control p-2 pl-4 text-lg border border-gray-300 rounded focus:outline-none focus:ring focus:border-blue-500">
                    </div>

                    <div class="form-group mb-4">
                        <label for="note" class="block text-lg font-medium text-gray-700">Note Content</label>
                        <textarea name="note" id="editNoteContent" class="w-full form-control p-2 pl-4 text-lg border border-gray-300 rounded focus:outline-none focus:ring focus:border-blue-500" rows="10" onkeypress="return allowOnlyLetters(event)"></textarea>
                    </div>

                    <button type="submit" id="submit-btn" class="btn btn-primary bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Update Note</button>
                </form>
            </div>

        </div>
    </div>
</div>

<script>
    let originalNoteContent = '';
    let originalAuthor = '';
    let originalYear = '';

    function openEditModal(noteData) {
        const modal = document.getElementById('editmodal');
        const form = document.getElementById('editNoteForm');
        const textarea = document.getElementById('editNoteContent');
        const authorInput = document.getElementById('editNoteAuthor');
        const yearInput = document.getElementById('editNoteYear');
        
        // Set the form action
        form.action = `/note/${noteData.id}`;
        
        // Set the form fields and store original content
        textarea.value = noteData.note;
        authorInput.value = noteData.author;
        yearInput.value = noteData.year;
        originalNoteContent = noteData.note;
        originalAuthor = noteData.author;
        originalYear = noteData.year;
        
        // Show the modal
        modal.classList.add('opacity-100', 'pointer-events-auto');
    }

    function closeEditModal() {
        document.getElementById('editmodal').classList.remove('opacity-100', 'pointer-events-auto');
        originalNoteContent = '';
        originalAuthor = '';
        originalYear = '';
    }

    document.addEventListener('click', function(event) {
        if (event.target === document.getElementById('editmodal')) {
            closeEditModal();
        }
    });

    document.querySelectorAll('.editmodal-close').forEach(function(element) {
        element.addEventListener('click', function() {
            closeEditModal();
        });
    });

    const editSubmitBtn = document.getElementById('submit-btn');

    function showAlert(config) {
        return Swal.fire({
            icon: config.icon || 'error',
            title: config.title || 'Error',
            text: config.text
        });
    }

    function validateForm() {
        const noteTextarea = document.getElementById('editNoteContent');
        const authorInput = document.getElementById('editNoteAuthor');
        const yearInput = document.getElementById('editNoteYear');
        const noteValue = noteTextarea.value;
        const authorValue = authorInput.value;
        const yearValue = yearInput.value;

        const validationRules = [
            {
                condition: noteValue.trim() === '',
                message: 'Please enter some text.',
                action: () => {
                    editSubmitBtn.classList.remove('bg-blue-500', 'hover:bg-blue-700');
                    editSubmitBtn.classList.add('bg-red-500', 'hover:bg-red-700');
                }
            },
            {
                condition: authorValue.trim() === '',
                message: 'Please enter an author name.'
            },
            {
                condition: yearValue.trim() === '',
                message: 'Please enter a year.'
            },
            {
                condition: !/^\d{4}$/.test(yearValue),
                message: 'Please enter a valid 4-digit year.'
            },
            {
                condition: noteValue.length > 1000,
                message: 'The text limit of 1000 characters has been exceeded.'
            },
            {
                condition: noteValue.trim() === originalNoteContent.trim() && 
                          authorValue.trim() === originalAuthor.trim() && 
                          yearValue === originalYear,
                message: 'No changes were made to any fields.',
                config: { icon: 'warning', title: 'No Changes' }
            }
        ];

        const failedRule = validationRules.find(rule => rule.condition);
        
        if (failedRule) {
            if (failedRule.action) {
                failedRule.action();
            }
            showAlert({
                icon: failedRule.config?.icon || 'error',
                title: failedRule.config?.title || 'Error',
                text: failedRule.message
            });
            return false;
        }

        editSubmitBtn.classList.remove('bg-red-500', 'hover:bg-red-700');
        editSubmitBtn.classList.add('bg-blue-500', 'hover:bg-blue-700');
        return true;
    }

    function allowOnlyLetters(event) {
        const charCode = event.which || event.keyCode;
        if (!((charCode >= 65 && charCode <= 90) || (charCode >= 97 && charCode <= 122) || charCode === 32)) {
            event.preventDefault();
            return false;
        }
        return true;
    }
</script>