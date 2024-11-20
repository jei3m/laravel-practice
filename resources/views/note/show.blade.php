<x-layout>
    <div class="note-container">
        <h1 class="note-title">Note Details</h1>
        <div class="note-body">
            {{ $note->note }}
        </div>
        <a href="{{ route('note.index') }}" class="note-action note-edit-button">Back to Notes</a>
    </div>
</x-layout>