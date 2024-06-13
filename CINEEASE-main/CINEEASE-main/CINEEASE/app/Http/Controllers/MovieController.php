<?php

// app/Http/Controllers/MovieController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;

class MovieController extends Controller
{
    public function create()
    {
        return view('admin.movies.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'poster' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'required|string',
            'date_showing' => 'required|date',
            'amount' => 'required|numeric',
            'seats_available' => 'required|integer', // Ensure seats_available is required
        ]);
        

        $posterPath = $request->file('poster')->store('posters', 'public');

        Movie::create([
            'title' => $validatedData['title'],
            'poster' => $posterPath,
            'description' => $validatedData['description'],
            'date_showing' => $validatedData['date_showing'],
            'amount' => $validatedData['amount'],
            'seats_available' => $validatedData['seats_available'],
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Movie added successfully.');
    }
}

