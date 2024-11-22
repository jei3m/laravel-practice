{{-- <x-layout>
    <div class="note-container max-w-lg mx-auto p-4 mt-6 bg-white rounded shadow-md">
        <h1 class="note-title text-3xl font-bold mb-4">Edit Note</h1>
        <form action="{{ route('note.update', $note->id) }}" method="POST" class="note-form flex flex-col" onsubmit="return validateForm()">
            @csrf
            @method('PUT')
            <div class="form-group mb-4">
                <label for="note" class="block text-lg font-medium text-gray-700">Note Content</label>
                <textarea name="note" id="note" class="w-full form-control p-2 pl-4 text-lg border border-gray-300 rounded focus:outline-none focus:ring focus:border-blue-500" rows="10" onkeypress="return allowOnlyLetters(event)">{{ $note->note }}</textarea>
            </div>
            <button type="submit" id="submit-btn" class="btn btn-primary bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Update Note</button>
        </form>
        @if (session('success'))
            <div class="alert alert-success mt-4">
                {{ session('success') }}
            </div>
        @endif
    </div>  
</x-layout>

<script>
    const submitBtn = document.getElementById('submit-btn');

    function validateForm() {
        const noteTextarea = document.getElementById('note');
        const noteValue = noteTextarea.value;

        if (noteValue.trim() === '') {
            submitBtn.classList.remove('bg-blue-500', 'hover:bg-blue-700');
            submitBtn.classList.add('bg-red-500', 'hover:bg-red-700');
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Please enter some text.',
            });
            return false;
        }

        if (noteValue.length > 1000) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'The text limit of 1000 characters has been exceeded.',
            });
            return false;
        }

        submitBtn.classList.remove('bg-red-500', 'hover:bg-red-700');
        submitBtn.classList.add('bg-blue-500', 'hover:bg-blue-700');
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

<script>

</script> --}}