<x-layout>
    <div class="note-container max-w-lg mx-auto p-4 mt-6 bg-white rounded shadow-md">
        <h1 class="note-title text-3xl font-bold mb-4">Create New Note</h1>
        <form action="{{ route('note.store') }}" method="POST" class="note-form flex flex-col">
            @csrf
            <div class="form-group mb-4">
                <label for="note" class="block text-lg font-medium text-gray-700">Note Content</label>
                <textarea name="note" id="note" class="w-full form-control p-2 pl-4 text-lg border border-gray-300 rounded focus:outline-none focus:ring focus:border-blue-500" rows="10"></textarea>
            </div>
            <button type="submit" class="btn btn-primary bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Create Note</button>
        </form>
    </div>
</x-layout>