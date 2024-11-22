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
    
        $notes = Note::query()->orderBy('created_at', 'desc');
    
        if (!empty($search)) {
            $notes->where('note', 'LIKE', '%' . $search . '%');
        }
    
        $notes = $notes->paginate($perPage);
    
        return view('note.index', ['notes' => $notes]);
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
        ]);
    
        $note = new Note();
        $note->note = $request->input('note');
        $note->user_id = 1;
        $note->save();
    
        return redirect()->route('note.index')->with('success', 'Note created successfully!');
    
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
        // return response()->json(['message' => 'Note updated successfully!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Note $note)
    {
        $note->delete();

        return redirect()->route('note.index')->with('success', 'Note deleted successfully!');
    }

    // public function editAjax(Note $note)
    // {
    //     return response()->json($note);
    // }
    
}