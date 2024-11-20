<x-layout>
    <div class="note-container">
        <h1 class="note-title">Edit Note</h1>
        <form action="{{ route('note.update', $note) }}" method="POST" class="note-form">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="note">Note Content</label>
                <textarea name="note" id="note" class="form-control" rows="10">{{ $note->note }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update Note</button>
        </form>
    </div>
</x-layout>