<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Author;
use DataTables;
use Illuminate\Support\Facades\Auth;

class AuthorController extends Controller
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

            $data = Author::latest()->get();
            return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                        $btn = '
                        <a href="'.route('author.edit', $row->id).'" class="edit btn btn-primary btn-sm">Edit</a>
                        <a href="/author/delete/'.$row->id.'" class="edit btn btn-danger btn-sm">Delete</a>
                        ';
                        return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
        }

        return view('author.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('author.create');
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
            'name' => 'required'
        ]);

        $author = new Author([
            'name' => $request->name,
        ]);

        $author->save();
        return redirect('/author')->with('success','Author saved');
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
        $author = Author::find($id);
        return view('author.edit', compact('author'));
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
            'name' => 'required'
        ]);

        $author = Author::find($id);
        $author->name = $request->name;

        $author->save();
        return redirect('/author')->with('success','Author updated');
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
            $user = User::find($id);
            $user->delete();
            return redirect('/author')->with('success','User Deleted');
        }else{
            return redirect('/author')->with('error','You are not admin, only admin can delete record.');
        }
    }
}