<x-layout>
    <div class="mt-4 max-w-4xl h-auto mx-auto p-4 p-bg-white rounded shadow-md">
        <div class="flex flex-col md:flex-row justify-between mb-4 space-y-4 md:space-y-0 md:space-x-4">
            <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                <button class="bg-blue-500 text-white font-bold px-4 h-10 rounded w-full sm:w-auto" onclick="openCreateModal()">
                    Create Note
                </button>
                
                {{-- Dropdown for sorting --}}
                <form action="{{ route('note.index') }}" method="GET" class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-2 rounded-md">
                    <input type="hidden" name="perPage" value="{{ request('perPage', 5) }}">
                    <select name="sort_by" class="w-full sm:w-auto rounded border border-gray-300 h-10 px-2" onchange="this.form.submit()">
                        <option value="all" {{ request('sort_by') == 'all' || !request('sort_by') ? 'selected' : '' }}>Show All</option>
                        <option value="note" {{ request('sort_by') == 'note' ? 'selected' : '' }}>Sort by Note</option>
                        <option value="author" {{ request('sort_by') == 'author' ? 'selected' : '' }}>Sort by Author</option>
                        <option value="year" {{ request('sort_by') == 'year' ? 'selected' : '' }}>Sort by Year</option>
                    </select>

                    @if (request('sort_by') == 'author' || request('sort_by') == 'note' || request('sort_by') == 'year')
                        <select name="sort_order" class="w-full sm:w-auto rounded border border-gray-300 h-10 px-2" onchange="this.form.submit()">
                            <option value="asc" {{ request('sort_order') == 'asc' ? 'selected' : '' }}>Ascending</option>
                            <option value="desc" {{ request('sort_order') == 'desc' ? 'selected' : '' }}>Descending</option>
                        </select>
                    @endif

                </form>
            </div>

            {{-- Search function while maintaining selected filtering and pagination value --}}
            <form action="{{ route('note.index') }}" method="GET" class="flex flex-col sm:flex-row space-y-2 sm:space-y-0">
                <input type="hidden" name="perPage" value="{{ request('perPage', 5) }}">
                <input type="hidden" name="sort_by" value="{{ request('sort_by', 'all') }}">
                <input type="hidden" name="sort_order" value="{{ request('sort_order', 'asc') }}">
                <input type="search" name="search" value="{{ request('search') }}" placeholder="Search notes..." class="w-full h-10 px-4 border border-gray-300 rounded sm:rounded-r-none">
                <button type="submit" class="bg-gray-200 hover:bg-gray-300 text-gray-600 h-10 px-4 rounded sm:rounded-l-none w-full sm:w-auto">Search</button>
            </form>
        </div>

        {{-- Table Header depending on which column it is --}}
        <div class="overflow-x-auto">
            <table class="overflow-x-auto w-full table-auto border-collapse min-w-full">
                <thead>
                    <tr class="bg-gray-50">
                        @if(request('sort_by') == 'all' || request('sort_by') == 'note' || request('sort_by') == '')
                            <th class="text-left p-4">Note</th>
                        @endif

                        @if(request('sort_by') == 'all' || request('sort_by') == 'author' || request('sort_by') == '' )
                            <th class="text-left p-4">Author</th>
                        @endif

                        @if(request('sort_by') == 'all' || request('sort_by') == 'year' || request('sort_by') == '')
                            <th class="text-left p-4">Year</th>
                        @endif
                        
                        <th class="text-right p-4">Actions</th>
                    </tr>
                </thead>

                {{-- Table data which are notes, author, and year. Also action dropdown --}}
                <tbody>
                    @foreach ($notes as $note)
                        <tr class="border-t border-gray-200 hover:bg-gray-50">
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
                                <select class="border border-gray-300 rounded py-2 outline-none w-32">
                                    <option value="">Actions</option>
                                    <option value="view" data-url="{{ route('note.show', $note) }}">View</option>
                                    <option value="edit" data-note='{{json_encode($note)}}'>Edit</option>
                                    <option value="delete" data-note-id="{{ $note->id }}">Delete</option>
                                </select>
                                <form action="{{ route('note.destroy', $note) }}" method="POST" class="hidden" id="delete-form-{{ $note->id }}">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Pagination Component --}}
        <div class="pagination mt-4 p-4 overflow-x-auto">
            {{ $notes->appends(['perPage' => request('perPage'), 'sort_by' => request('sort_by'), 'sort_order' => request('sort_order')])->links('components.pagination') }}
        </div>
        
        {{-- Sweet Alert for Edit and Create success --}}
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
    // Sweet Alert for Delete
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

    // To enable dropdown actions
    document.querySelectorAll('select').forEach(select => {
        select.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const value = this.value;

            if (!value) return; // Do nothing if it's the default "Actions" option

            switch(value) {
                case 'view':
                    window.location.href = selectedOption.dataset.url;
                    break;
                case 'edit':
                    const noteData = JSON.parse(selectedOption.dataset.note);
                    openEditModal(noteData);
                    break;
                case 'delete':
                    confirmDelete(selectedOption.dataset.noteId);
                    break;
            }

            // Reset dropdown selections after an action
            this.value = '';
        });
    });
</script>

@include('components.create-modal')
@include('components.edit-modal')