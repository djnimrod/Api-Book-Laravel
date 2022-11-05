<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{

    public function index()
    {
        return Book::all();

    }

/**
 * param
 */
    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required']
        ]);

        $book = new Book;
        $book->title = $request->input('title');

        $book->save();

        return $book;
    }


/**
 * @param Book $book
 */
    public function show( Book $book)
    {
        return $book;

    }

    public function update(Request $request, Book $book)
    {

       $request->validate([
            'title' => ['required']
        ]);

        $book->title = $request->input('title');

        $book->save();

        return $book;
    }

    public function destroy(Book $book)
    {
        //return $book;
        $book->delete();

        return response()->noContent();
    }
}
