<x-layout>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <div class="note-container">
        <a href="{{ route('note.create') }}" class="new-note-btn">
            New Note
        </a>
        <div class="notes-list">
            @foreach ($notes as $note)
                <div class="note-item">
                    <div class="note-body">
                        {{-- Shrink content to 30 words --}}
                        {{ Str::words($note->note, 30) }} 
                    </div>

                    <div class="note-actions">
                        <a href="{{ route('note.show', $note) }}" class="note-action note-view-button">View</a>
                        <a href="{{ route('note.edit', $note) }}" class="note-action note-edit-button">Edit</a>
                        <form action="{{ route('note.destroy', $note) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="note-action note-delete-button">Delete</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-layout>