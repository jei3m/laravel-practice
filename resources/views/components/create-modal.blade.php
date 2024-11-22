<div id="modal" class="modal opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center">
    <div class="modal-close modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>
    <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">

        <!-- Add your modal content here -->
        <div class="modal-content py-4 text-left px-6">
            <div class="flex justify-between items-center pb-3">
                <p class="text-2xl font-bold">Create New Note</p>
                <div class="modal-close cursor-pointer z-50">
                    <svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                        <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                    </svg>
                </div>
            </div>

            <div class="note-container w-full mx-auto">
                <form action="{{ route('note.store') }}" method="POST" class="note-form flex flex-col" onsubmit="return validateCreateForm()">
                    @csrf
                    <div class="form-group mb-4">
                        <label for="note" class="block text-lg font-medium text-gray-700">Note Content</label>
                        <textarea name="note" id="note" class="w-full form-control p-2 pl-4 text-lg border border-gray-300 rounded focus:outline-none focus:ring focus:border-blue-500" rows="10"></textarea>
                    </div>
                    
                    <button type="submit" id="submit-btn" class="btn btn-primary bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Create Note</button>
                </form>
                @if (session('success'))
                    <div class="alert alert-success mt-4">
                        {{ session('success') }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>

<script>
    function openCreateModal() {
        document.getElementById('modal').classList.add('opacity-100', 'pointer-events-auto');
    }

    function closeCreateModal() {
        document.getElementById('modal').classList.remove('opacity-100', 'pointer-events-auto');
    }

    document.addEventListener('click', function(event) {
        if (event.target === document.getElementById('modal')) {
            closeCreateModal();
        }
    });

    document.querySelectorAll('.modal-close').forEach(function(element) {
        element.addEventListener('click', function() {
            closeCreateModal();
        });
    });

    const createSubmitBtn = document.getElementById('submit-btn');

    function validateCreateForm() {
        const noteTextarea = document.getElementById('note');
        const noteValue = noteTextarea.value;

        console.log('Create form submission attempted');
        console.log('Note value:', noteValue);

        if (noteValue.trim() === '') {
            console.log('Empty note detected');
            createSubmitBtn.classList.remove('bg-blue-500', 'hover:bg-blue-700');
            createSubmitBtn.classList.add('bg-red-500', 'hover:bg-red-700');
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Please enter some text.',
            });
            return false;
        }

        if (noteValue.length > 1000) {
            console.log('Note too long:', noteValue.length);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'The text limit of 1000 characters has been exceeded.',
            });
            return false;
        }

        console.log('Form validation passed, submitting...');
        createSubmitBtn.classList.remove('bg-red-500', 'hover:bg-red-700');
        createSubmitBtn.classList.add('bg-blue-500', 'hover:bg-blue-700');
        return true;
    }
</script>