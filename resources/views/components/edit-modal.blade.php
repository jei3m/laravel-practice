<div id="modal-edit" class="modal opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center">
    <div class="modal-close modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>
    <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">
        <div class="modal-content py-4 text-left px-6">
            <div class="flex justify-between items-center pb-3">
                <p class="text-2xl font-bold">Edit Note</p>
                <div class="modal-close cursor-pointer z-50">
                    <svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                        <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                    </svg>
                </div>
            </div>
            <form action="{{ route('note.update', $note->id) }}" method="POST" class="note-form flex flex-col" onsubmit="return validateForm()">
                @csrf
                @method('PUT')
                <input type="hidden" id="note-id" value="">
                <textarea id="note-content" class="w-full form-control p-2 pl-4 text-lg border border-gray-300 rounded focus:outline-none focus:ring focus:border-blue-500" rows="10"></textarea>
                <button type="submit" id="submit-btn" class="btn btn-primary bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Update Note</button>
            </form>
        </div>
    </div>
</div>

<script>
    function openEditModal(noteId) {
        // Get the note data from the server
        axios.get('/note/' + noteId + '/edit')
            .then(response => {
                // Update the modal's content with the note data
                const note = response.data;
                document.getElementById('note-id').value = noteId; // Update this line
                document.getElementById('note-content').value = note.note;
                // Show the modal
                document.getElementById('modal-edit').classList.add('opacity-100', 'pointer-events-auto');
            })
            .catch(error => {
                console.error(error);
            });
    }

    function closeEditModal() {
        document.getElementById('modal-edit').classList.remove('opacity-100', 'pointer-events-auto');
    }

    document.addEventListener('click', function(event) {
        if (event.target === document.getElementById('edit-modal')) {
            closeEditModal();
        }
    });

    document.querySelectorAll('.modal-close').forEach(function(element) {
        element.addEventListener('click', function() {
            closeEditModal();
        });
    });

    const submitBtn = document.getElementById('submit-btn');

    submitBtn.addEventListener('click', function(event) {
        event.preventDefault();
        const noteId = document.getElementById('note-id').value;
        const noteContent = document.getElementById('note-content').value;

        axios.put('/note/' + noteId, {
            id: noteId, // Add this line
            note: noteContent,
        })
        .then(response => {
            // Hide the modal
            closeEditModal();
            // Reload the notes list
            window.location.reload();
        })
        .catch(error => {
            console.error(error);
        });
    });
</script>