<x-layout>
    <div class="note-container">
        <h1 class="note-title">Create New Note</h1>
        <form action="{{ route('note.store') }}" method="POST" class="note-form">
            @csrf
            <div class="form-group">
                <label for="note">Note Content</label>
                <textarea name="note" id="note" class="form-control" rows="10"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Create Note</button>
        </form>
    </div>
</x-layout>