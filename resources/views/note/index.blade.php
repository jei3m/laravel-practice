<x-layout>
    <div class="mt-4 max-w-4xl h-auto mx-auto p-4 md:p-6 lg:p-8 bg-white rounded shadow-md">
        <div class="flex justify-between mb-4 space-x-4">
            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded" onclick="openCreateModal()">
                Create New Note
            </button>

            <form action="{{ route('note.index') }}" method="GET" class="flex justify-end">
                <input type="search" name="search" placeholder="Search notes..." class="w-full p-2 pl-4 text-lg border border-gray-300 rounded-l">
                <button type="submit" class="bg-gray-200 hover:bg-gray-300 text-gray-600 py-2 px-4 rounded-r">Search</button>
            </form>
        </div>
        <table class="w-full table-auto border-collapse">
            <thead>
                <tr>
                    <th class="text-left p-4 w-3/4">Note</th>
                    <th class="text-right p-4 w-1/4">Actions</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($notes as $note)
                    <tr>
                        <td class="p-4">{{ Str::limit($note->note, 50) }}</td>  
                        <td class="text-right p-4" style="white-space: nowrap;">


                            <a onclick="openEditModal({{json_encode($note)}})" class="bg-gray-200 hover:bg-gray-300 text-gray-600 py-2 px-4 rounded mr-2">Edit Modal</a>
                            <a href="{{ route('note.show', $note) }}" class="bg-gray-200 hover:bg-gray-300 text-gray-600 py-2 px-4 rounded mr-2">View</a>
                            <a href="{{ route('note.edit', $note) }}" class="bg-gray-200 hover:bg-gray-300 text-gray-600 py-2 px-4 rounded mr-2">Edit</a>
                            <form action="{{ route('note.destroy', $note) }}" method="POST" style="display:inline;" id="delete-form-{{ $note->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="bg-red-500 hover:bg-red-700 text-white py-2 px-4 rounded" onclick="confirmDelete({{ $note->id }})">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="pagination mt-4 p-4">
            {{-- {{ $notes->links('components.pagination') }} --}}
            {{ $notes->appends(['perPage' => request('perPage')])->links('components.pagination') }}

        </div>
        
        @if (session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    timer: 3000,
                    showConfirmButton: true,
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#3085d6'
                });
            </script>
        @endif
    </div>
</x-layout>

<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Cancel',
            cancelButtonColor: '#3085d6',
            confirmButtonColor: '#d33',
            confirmButtonText: 'Delete',
            reverseButtons: true,
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        });
    }

</script>

@include('components.create-modal')
@include('components.edit-modal')