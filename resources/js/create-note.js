document.getElementById('create-note-btn').addEventListener('click', function() {
    const noteContent = document.getElementById('note').value;
    axios.post(noteStoreUrl, {
        note: noteContent,
    })
    // ...
});