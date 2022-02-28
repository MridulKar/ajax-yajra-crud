<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use DataTables;

class BooksController extends Controller
{
    public function index()
    {
        // $books = Book::all();
        // return Datatables()->of($books)
        // ->addIndexColumn()

        // ->addColumn('status', function($book) {
        //     $status = '';
        //     if($book->status == 1){
        //         $status .= '<span style="background-color: #97df1a; border-radius: 3px; padding: 3px;">Active</span>';
        //     }else{
        //         $status .= '<span style="background-color: #fe7472; border-radius: 3px; padding: 3px;">Inactive</span>';
        //     }
        //     return $status;
        // })

        // ->addColumn('action', 'book-action')
        // ->addColumn('image', 'show-image')
        // ->rawColumns(['status', 'action', 'image'])
        // ->make(true);

        if (request()->ajax()) { 
            $books = Book::all();
            return DataTables()->of($books)
            ->addIndexColumn()
    
            ->addColumn('status', function($book) {
                $status = '';
                if($book->status == 1){
                    $status .= '<span style="background-color: #97df1a; border-radius: 3px; padding: 3px;">Active</span>';
                }else{
                    $status .= '<span style="background-color: #fe7472; border-radius: 3px; padding: 3px;">Inactive</span>';
                }
                return $status;
            })

            ->addColumn('active', function($book){
                if($book->status == 1){
                    $status = ' <a href="book/status/'.$book->id.'" class="btn btn-danger" title="Click to Deactive class" style="padding: 2px;"> 
                    update
                                </a> ';
                }else{
                    $status = ' <a href="book/status/'.$book->id.'" class="btn btn-success" title="Click to Deactive class" style="padding: 2px;"> 
                                   update
                                </a>';
                }

                return $status;
            })
    
            ->addColumn('action', 'book-action')
            ->addColumn('image', 'show-image')
            
            ->rawColumns(['status','action', 'image','active'])
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

    //===Status Active Inactive===

    public function status($id){
        $book = Book::find($id);

        if($book->status == 1){
            $book->status = 0;
        }
        else{
            $book->status = 1;
        }
        
        $book -> save();
        return redirect()->route('ajax.dataTable')->with('message','Data updated Successfully');
    }
}
