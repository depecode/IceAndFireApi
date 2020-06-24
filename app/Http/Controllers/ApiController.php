<?php

namespace App\Http\Controllers;

use App\Core\Book;
use Illuminate\Http\Request;
use App\Book as BookModel;
use App\Author;

class ApiController extends Controller
{
    public function __construct(Book $book)
    {
        $this->book = $book;
    }

    public function index()
    {
        // Get all the book
        $books = $this->book->all();
        return $books;
    }

    public function show($id)
    {
        $book = $this->book->findById($id);

        return $book;
    }

    public function createBook(Request $request)
    {
     
        $book = new BookModel;
        $book->name = $request->name;
        $book->isbn = $request->isbn;
        $book->author_id = $request->author_id;
        $book->country = $request->country;
        $book->number_of_pages = $request->number_of_pages;
        $book->publisher = $request->publisher;
        $book->release_date = $request->release_date;
        $book->save();

        return response()->json([
            "message" => "book record created",
        ], 201);
    }

    public function getAllBooks()
    {
        $books = BookModel::get()->toJson(JSON_PRETTY_PRINT);
        return response($books, 200);
    }

    public function getBook($id)
    {
        if (BookModel::where('id', $id)->exists()) {
            $book = BookModel::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
            return response($book, 200);
        } else {
            return response()->json([
                "message" => "Book not found",
            ], 404);
        }
    }

    public function updateBook(Request $request, $id)
    {
        if (BookModel::where('id', $id)->exists()) {
            $book = BookModel::find($id);
            $book->name = is_null($request->name) ? $book->name : $request->name;
            $book->number_of_pages = is_null($request->number_of_pages) ? $book->number_of_pages : $request->number_of_pages;
            $book->publisher = is_null($request->publisher) ? $book->publisher : $request->publisher;
            $book->release_date = is_null($request->release_date) ? $book->release_date : $request->release_date;
            // $book->author_id = is_null($author_model->id) ? $author_model->id : $request->release_date;
            $book->save();

            return response()->json([
                "message" => "records updated successfully",
            ], 200);
        } else {
            return response()->json([
                "message" => "Book not found",
            ], 404);

        }
    }

    public function deleteBook($id)
    {
        if (BookModel::where('id', $id)->exists()) {
            $book = BookModel::find($id);
            $book->delete();

            return response()->json([
                "message" => "records deleted",
            ], 202);
        } else {
            return response()->json([
                "message" => "Book not found",
            ], 404);
        }
    }

}
