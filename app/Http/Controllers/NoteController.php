<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('perPage', 5);
        $sortBy = $request->input('sort_by', 'created_at');
        $sortOrder = $request->input('sort_order', 'desc');
    
        // Search function
        $notes = Note::query();
    
        if (!empty($search)) {
            $notes->where(function($query) use ($search) {
                $query->where('note', 'LIKE', '%' . $search . '%')
                      ->orWhere('year', 'LIKE', '%' . $search . '%')
                      ->orWhere('author', 'LIKE', '%' . $search . '%');
            });
        }

        // Apply sorting only if not "all"
        if ($sortBy !== 'all') {
            $notes->orderBy($sortBy, $sortOrder);
        }
    
        $notes = $notes->paginate($perPage);

        // For URL parameters
        $notes->appends([
            'perPage' => $perPage,
            'sort_by' => $sortBy,
            'sort_order' => $sortOrder,
            'search' => $search
        ]);
    
        // Return index view with pagination and sorting
        return view('note.index', [
            'notes' => $notes,
            'sortBy' => $sortBy,
            'sortOrder' => $sortOrder
        ]);
    }

    /**
     * Show the form for creating a new resource.
    */
    public function create()
    {
        return view('note.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'note' => 'required',
            'author' => 'required',
            'year' => 'required'
        ]);
    
        $note = new Note();
        $note->note = $request->input('note');
        $note->author = $request->input('author');
        $note->year = $request->input('year');
        $note->save();
    
        // Redirect back to the index page with the sorting and pagination parameters
        return redirect()->route('note.index', [
            'perPage' => $request->input('perPage', 5),
            'sort_by' => $request->input('sort_by', 'all'),
            'sort_order' => $request->input('sort_order', 'desc')
        ])->with('success', 'Note created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Note $note)
    {
        return view('note.show', ['note' => $note]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Note $note)
    {
        return view('note.edit', ['note' => $note]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Note $note)
    {
        $request->validate([
            'note' => 'required',
        ]);
    
        $note->note = $request->input('note');
        $note->save();
    
        return redirect()->route('note.index')->with('success', 'Note updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Note $note)
    {
        $note->delete();

        return redirect()->route('note.index')->with('success', 'Note deleted successfully!');
    }

}