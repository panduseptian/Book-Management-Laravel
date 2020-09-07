<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Book;
use App\Author;
use DataTables;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        //
        if ($request->ajax()) {

            $data = Book::latest()->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('author', function($row){
                        $a = "";
                        foreach($row->author as $author){
                            $a .= '<span class="badge badge-success">'.$author->name.'</span>';
                        }
                        return $a;
                    })
                    ->addColumn('action', function($row){
                        $btn = '
                        <a href="'.route('book.edit', $row->id).'" class="edit btn btn-primary btn-sm">Edit</a>
                        <a href="/book/delete/'.$row->id.'" class="edit btn btn-danger btn-sm">Delete</a>
                        ';
                        return $btn;
                    })
                    ->rawColumns(['action','author'])
                    ->make(true);
        }

        return view('book.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $authors = Author::all();
        return view('book.create', compact('authors'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' =>'required',
            'description' =>'required',
        ]);

        $book = new Book([
            'name' => $request->name,
            'description' => $request->description,
        ]);
        $book->save();
        
        $ids = [];
        foreach($request->author as $authorID){
            $book->author()->attach($authorID);
        }
        
        return redirect('/book')->with('success','New book created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $book = Book::find($id);
        $authors = Author::all();
        $authorIDS = [];
        foreach($book->author as $author){
            $authorIDS[] = $author->id;
        }
        return view('book.edit', compact('authors','book','authorIDS'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $request->validate([
            'name' =>'required',
            'description' =>'required',
        ]);

        $book = Book::find($id);
        $book->name = $request->name;
        $book->description = $request->description;
        $book->save();
        
        $ids = [];
        foreach($request->author as $authorID){
            $ids[] = $authorID;
        }

        $book->author()->sync($ids);
        
        return redirect('/book')->with('success','Book updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        if (Auth::user()->level == 'admin'){
            $book = Book::find($id);
            $book->delete();
            return redirect('/book')->with('success','Book Deleted');
        }else{
            return redirect('/book')->with('error','You are not admin, only admin can delete record.');
        }
    }
}