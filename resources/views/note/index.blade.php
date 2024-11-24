<x-layout>
    <div class="mt-4 max-w-4xl h-auto mx-auto p-4 p-bg-white rounded shadow-md">
        <div class="flex justify-between mb-4 space-x-4">
            <div class="flex space-x-4">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded" onclick="openCreateModal()">
                    Create New Note
                </button>
                
                <form action="{{ route('note.index') }}" method="GET" class="flex items-center border border-gray-300 rounded-md mr-1">
                    <input type="hidden" name="perPage" value="{{ request('perPage', 5) }}">
                    <select name="sort_by" class="p-2" onchange="this.form.submit()">
                        <option value="all" {{ request('sort_by') == 'all' || !request('sort_by') ? 'selected' : '' }}>Show All</option>
                        <option value="note" {{ request('sort_by') == 'note' ? 'selected' : '' }}>Sort by Note</option>
                        <option value="author" {{ request('sort_by') == 'author' ? 'selected' : '' }}>Sort by Author</option>
                        <option value="year" {{ request('sort_by') == 'year' ? 'selected' : '' }}>Sort by Year</option>
                    </select>
                    
                    <select name="sort_order" class="p-2" onchange="this.form.submit()">
                        <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>Ascending</option>
                        <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Descending</option>
                    </select>
                   
                </form>
                
            </div>

            <form action="{{ route('note.index') }}" method="GET" class="flex justify-end">
                <input type="hidden" name="perPage" value="{{ request('perPage', 5) }}">
                <input type="hidden" name="sort_by" value="{{ request('sort_by', 'all') }}">
                <input type="hidden" name="sort_order" value="{{ request('sort_order', 'asc') }}">
                <input type="search" name="search" value="{{ request('search') }}" placeholder="Search notes..." class="w-full p-2 pl-4 text-lg border border-gray-300 rounded-l">
                <button type="submit" class="bg-gray-200 hover:bg-gray-300 text-gray-600 py-2 px-4 rounded-r">Search</button>
            </form>
            
        </div>

        <table class="w-full table-auto border-collapse">

            <thead>
                <tr>
                    @if(request('sort_by') == 'all' || request('sort_by') == 'note')
                        <th class="text-left p-4 w-3/4">Note</th>
                    @endif

                    @if(request('sort_by') == 'all' || request('sort_by') == 'author')
                        <th class="text-left p-4 w-3/4">Author</th>
                    @endif

                    @if(request('sort_by') == 'all' || request('sort_by') == 'year')
                        <th class="text-left p-4 w-3/4">Year</th>
                    @endif
                    
                    <th class="text-right p-4 w-1/4">Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($notes as $note)
                    <tr>
                        @if(request('sort_by') == 'all' || !request('sort_by') || request('sort_by') == 'note')
                            <td class="p-4">{{ Str::limit($note->note, 50) }}</td>  
                        @endif
                        @if(request('sort_by') == 'all' || !request('sort_by') || request('sort_by') == 'author')
                            <td class="p-4">{{ ($note->author) }}</td>  
                        @endif
                        @if(request('sort_by') == 'all' || !request('sort_by') || request('sort_by') == 'year')
                            <td class="p-4">{{ ($note->year) }}</td>  
                        @endif
                        
                        <td class="text-right p-4" style="white-space: nowrap;">

                            <a href="{{ route('note.show', $note) }}" class="bg-gray-200 hover:bg-gray-300 text-gray-600 py-2.5 px-4 rounded mr-2">View</a>
                            <button onclick="openEditModal({{json_encode($note)}})" class="bg-gray-200 hover:bg-gray-300 text-gray-600 py-2 px-4 rounded mr-2">Edit</button>
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
            {{ $notes->appends(['perPage' => request('perPage'), 'sort_by' => request('sort_by'), 'sort_order' => request('sort_order')])->links('components.pagination') }}
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
                }).then((result) => {
                    if (result.isConfirmed) {
                    
                        window.location.href = '/note';
                    }
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