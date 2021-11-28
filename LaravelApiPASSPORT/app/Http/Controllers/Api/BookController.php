<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    //CREATE BOOK - POST
    //URL http://localhost:8000/api/create-book
    public function createBook(Request $request)
    {
        $request->validate([
            "title" => "required",
            "book_cost" => "required"
        ]);

        Book::create([
            "author_id" => auth()->user()->id,
            "title" => $request->title,
            "description" => $request->description,
            "book_cost" => $request->book_cost
        ]);

        return response()->json([
            "status" => "success",
            "message" => "Book created successfully"
        ], 201);
    }

    // LIST API - GET
    //URL http://localhost:8000/api/list-books
    public function listBooks()
    {
        //List all Books all authors created
        $books = Book::get();
        return response()->json([
            "status" => "success",
            "message" => "All books",
            "data" => $books
        ], 200);
    }

    // LIST API - GET
    //URL http://localhost:8000/api/author-book
    public function authorBook()
    {
        $author_id = auth()->user()->id;

        $books = Author::find($author_id)->books;

        return response()->json([
            "status" => "success",
            "message" => "All books",
            "data" => $books
        ], 200);
    }

    //SINGLE BOOK API - GET
    //URL http://localhost:8000/api/single-book
    public function singleBook($book_id)
    {
        $author_id = auth()->user()->id;

        if (Book::where(["author_id" => $author_id, "id" => $book_id])->exists()) {
            $book = Book::find($book_id);
            return response()->json([
                "status" => "status",
                "message" => "Author Book found",
                "data" => $book
            ], 200);
        } else {
            return response()->json([
                "status" => 0,
                "message" => "Author Book doesn't exists"
            ], 404);
        }
    }

    //UPDATE BOOK - POST
    //URL http://localhost:8000/api/update-book/{id}
    public function updateBook(Request $request, $book_id)
    {
        $author_id = auth()->user()->id;
        if (Book::where(["author_id" => $author_id, "id" => $book_id])->exists()) {
            $book = Book::find($book_id);

            $book->title = isset($request->title) ? $request->title : $book->title;
            $book->description = isset($request->description) ? $request->description : $book->description;
            $book->book_cost = isset($request->book_cost) ? $request->book_cost : $book->book_cost;
            $book->save();
            return response()->json([
                "status" => "success",
                "message" => "Author Book updated successfully",
                //"data" => $book
            ], 200);
        } else {
            return response()->json([
                "status" => 0,
                "message" => "Author Book doesn't exists"
            ], 404);
        }
    }

    //DELETE BOOK API - GET
    //URL http://localhost:8000/api/delete-book/{id}
    public function deleteBook($book_id)
    {
        $author_id = auth()->user()->id;
        if (Book::where(["author_id" => $author_id, "id" => $book_id])->exists()) {
            $book = Book::find($book_id);

            $book->delete();

            return response()->json([
                "status" => "success",
                "message" => "Author Book deleted successfully",
            ], 200);
        } else {
            return response()->json([
                "status" => 0,
                "message" => "Author Book doesn't exists"
            ], 404);
        }
    }
}
