<x-layout>
    <div class="max-w-4xl mx-auto p-4 md:p-6 lg:p-8 note-container">
        <h1 class="text-3xl font-bold mb-4 note-title">Edit Note</h1>
        <form action="{{ route('note.update', $note) }}" method="POST" class="note-form">
            @csrf
            @method('PUT')
            <div class="mb-4 form-group">
                <label for="note" class="block text-gray-700 text-sm font-bold mb-2">Note Content</label>
                <textarea name="note" id="note" class="block w-full p-2 pl-4 text-sm text-gray-700 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" rows="10">{{ $note->note }}</textarea>
            </div>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Update Note</button>
        </form>
    </div>
</x-layout>