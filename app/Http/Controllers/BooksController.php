<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

use Datatables;

class BooksController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of(Book::select('*'))
                ->addColumn('action', 'book-action')
                ->addColumn('image', 'show-image')
                ->rawColumns(['action', 'image'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('book-list');
    }

    public function store(Request $request)
    {  

        $bookId = $request->id;
        if($bookId){
            $book = Book::find($bookId);
            if ($request->hasFile('image')){
                $path = public_path() . "upload/images/" . $book->image;
                if (file_exists($path)) {
                    unlink($path);
                }
                $file      = $request->file('image');
                $imageName = $this->upload_image_file($file, 'upload/images/', "image");
            }
        }
        else{
            if ($request->hasFile('image')) {
                $file            = $request->file('image');
                $imageName = $this->upload_image_file($file , 'upload/images/', "image");
                $book = new Book;
            }
        }
        $book->image = $imageName;
        $book->title = $request->title;
        $book->code = $request->code;
        $book->author = $request->author;
        $book->save();
    
        return Response()->json($book);
    }


    public function edit(Request $request)
    {   
        $where = array('id' => $request->id);
        $book  = Book::where($where)->first();

        return Response()->json($book);
    }
     
    public function destroy(Request $request)
    {
        $book = Book::where('id',$request->id)->delete();
        
        return Response()->json($book);
    }
}
