<x-layout>
    <div class="max-w-2xl mx-auto p-4 mt-6 bg-white rounded-lg shadow-md note-container">
        <h1 class="text-3xl font-bold mb-4 note-title">Note Details</h1>
        <div class="text-lg leading-relaxed mb-6 note-body break-words">
            {{ $note->note }}
        </div>
        <a href="{{ route('note.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded note-action note-edit-button">Back to Notes</a>
    </div>
</x-layout>