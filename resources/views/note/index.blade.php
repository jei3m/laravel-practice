<x-layout>
    <div class="max-w-4xl mx-auto p-4 md:p-6 lg:p-8 note-container">
        <a href="{{ route('note.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded new-note-btn">
            New Note
        </a>
        <div class="mt-4 notes-list">
            @foreach ($notes as $note)
                <div class="bg-white shadow-md rounded p-4 mb-4 note-item">
                    <div class="text-gray-600 note-body">
                        {{-- Shrink content to 30 words --}}
                        {{ Str::words($note->note, 30) }} 
                    </div>

                    <div class="mt-2 flex justify-end note-actions">
                        <a href="{{ route('note.show', $note) }}" class="bg-gray-200 hover:bg-gray-300 text-gray-600 py-2 px-4 rounded mr-2 note-action note-view-button">View</a>
                        <a href="{{ route('note.edit', $note) }}" class="bg-gray-200 hover:bg-gray-300 text-gray-600 py-2 px-4 rounded mr-2 note-action note-edit-button">Edit</a>
                        <form action="{{ route('note.destroy', $note) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white py-2 px-4 rounded note-action note-delete-button">Delete</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-layout>