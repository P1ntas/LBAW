<?php

namespace App\Http\Controllers;

use App\Models\Book;

use App\Repositories\BookRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

class BookController extends AppBaseController
{
    private $bookRepository;

    public function __construct(BookRepository $bookRepo)
    {
        $this->bookRepository = $bookRepo;
    }

    public function index(Request $request)
    {
        $this->bookRepository->pushCriteria(new RequestCriteria($request));
        $books = $this->bookRepository->all();

        return view('books.index')->with('books', $books);
    }

    public function create()
    {
        return view('books.create');
    }

    public function store(Request $request)
    {
        $input = $request->all();

        $book = $this->bookRepository->create($input);

        Flash::success('Book saved successfully.');

        return redirect(route('books.index'));
    }

    public function show($id_book)
    {
        $book = $this->bookRepository->findWithoutFail($id_book);

        if (empty($book)) {
            Flash::error('Book not found');

            return redirect(route('books.index'));
        }

        return view('books.show')->with('book', $book);
    }

    public function edit($id_book)
    {
        $book = $this->bookRepository->findWithoutFail($id_book);

        if (empty($book)) {
            Flash::error('Book not found');

            return redirect(route('books.index'));
        }

        return view('books.edit')->with('book', $book);
    }

    public function update($id_book, Request $request)
    {
        $book = $this->bookRepository->findWithoutFail($id_book);

        if (empty($book)) {
            Flash::error('Book not found');

            return redirect(route('books.index'));
        }

        $book = $this->bookRepository->update($request->all(), $id_book);

        Flash::success('Book updated successfully.');

        return redirect(route('books.index'));
    }

    public function destroy($id_book)
    {
        $book = $this->bookRepository->findWithoutFail($id_book);

        if (empty($book)) {
            Flash::error('Book not found');

            return redirect(route('books.index'));
        }

        $this->bookRepository->delete($id_book);

        Flash::success('Book deleted successfully.');

        return redirect(route('books.index'));
    }
}
