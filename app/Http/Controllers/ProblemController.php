<?php

namespace App\Http\Controllers;

use App\Models\Problem;
use Illuminate\Http\Request;

class ProblemController extends Controller
{
    // READ: list all problems, or only those matching ?q=
    public function index(Request $request)
    {
        $q = trim((string) $request->query('q', ''));

        return view('problems.index', [
            'problems' => Problem::search($q)->orderBy('name')->get(),
            'q' => $q,
        ]);
    }

    // CREATE: show the empty form
    public function create()
    {
        return view('problems.create');
    }

    // CREATE: save the new problem
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable',
        ]);

        Problem::create($data);

        return redirect('/')->with('message', 'Problem created.');
    }

    // READ: show one problem with its solutions
    public function show(Problem $problem)
    {
        return view('problems.show', ['problem' => $problem]);
    }

    // UPDATE: show the form filled with current values
    public function edit(Problem $problem)
    {
        return view('problems.edit', ['problem' => $problem]);
    }

    // UPDATE: save the changes
    public function update(Request $request, Problem $problem)
    {
        $data = $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable',
        ]);

        $problem->update($data);

        return redirect('/problems/' . $problem->id)->with('message', 'Problem updated.');
    }

    // DELETE
    public function destroy(Problem $problem)
    {
        $problem->delete();

        return redirect('/')->with('message', 'Problem deleted.');
    }
}