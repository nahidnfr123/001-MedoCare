<?php

namespace App\Http\Controllers\Admin;

use App\Blog;
use App\BlogComment;
use App\BlogView;
use App\Rules\NameValidate;
use App\Rules\WordCountRule;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Blog = Blog::orderBy('id', 'DESC')->paginate(6);
        $Soft_Deleted_Blog = Blog::orderBy('id', 'DESC')->onlyTrashed()->paginate(6);
        return view('admin.blog.manage_blog', compact('Blog', 'Soft_Deleted_Blog'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function validation($request){
        Session::flash('Error_create', 'Create Error.');
        $request->validate([
            'title' => 'required|string|unique:blogs|max:160|min:3',
            'description' => ['required', new WordCountRule('Blog description',200,1000)],
            'image' => 'required|file|image|max:4096',
            'author' => ['required','min:3','max:60', new NameValidate],
            'publish_date' => 'required|date|after:yesterday',
        ], [
            'title.required' => 'Blog title is required.',
            //'title.string' => 'Blog title should be a string.',
            'title.unique' => 'Blog title should be unique.',
            'title.max' => 'Blog title should be less then 160 letters.',
            'title.min' => 'Blog title should be more then 3 letters.',

            'image.required' => 'Blog image is required.',
            'image.image' => 'Blog image must be a image file.',
            'image.file' => 'Blog image must be a image file.',
            'image.max' => 'Blog image must be less then 4096 Kb or 4 Mb.',
            'image.mimes' => 'Blog image can only contain jpg, jpeg and png file.',

            'description.required' => 'Blog description is required.',

            'author.required' => 'Author name is required.',
            'author.min' => 'Author name should be at-least 3 letters.',
            'author.max' => 'Author name should be less then 60 letters.',

            'publish_date.required' => 'Publish date is required.',
            'publish_date.date' => 'Publish date is not in correct format.',
            'publish_date.after' => 'Invalid blog publish date.',
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validation($request);

        $Publish_Date = $request->publish_date;
        $Date = strtotime($Publish_Date); //Initial date format ....
        $Time = date('H:i:s'); // get current time ...
        $Publish_Date = date('Y/m/d '.$Time, $Date);

        $title = ucwords(trim($request->title));
        $description = ucfirst(trim($request->description));

        $img_name = str_replace(array('?', '!', '.', ':', ' '), '-', $title);

        if ($request->hasFile('image')) {
            $get_image = $request->file('image'); // get the image form post method...
            $fileNameWithExt = $get_image->getClientOriginalName(); // get full file name ...
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME); // get only the file name without extension ....
            $extension = $get_image->getClientOriginalExtension();// get the file extension

            $allowed_Ext = array('jpg','jpeg', 'gif');
            if(in_array(strtolower($extension), $allowed_Ext, true) == false){
                return back()->withErrors('Error', 'Blog image can only contain jpg, jpeg and png file.');
            }
            //$fileNameToStore = $fileName.'_'.time().'.'.$extension;
            $newFileName = $img_name . '-' . time() . '.' . $extension; // Ste the file name to store in the database ....
            $Location = '/public/image/blog/';
            $get_image->storeAs($Location, $newFileName); // set the storage path ...
            $StorageLink = '/storage/image/blog/' . $newFileName;
        }
        else {
            $StorageLink = '';
        }

        Blog::Insert([
            // Database field name => Form request data
            'title' => $title,
            'image' => $StorageLink,
            'description' => $description,
            'author' => ucwords($request->author),
            'publish_date' => $Publish_Date,
            'created_at' => Carbon::now(),
        ]);

        Session::forget('Error_create');
        //return Redirect::back();
        return back()->with('Success', 'Blog successfully added.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $id = $this->decryptID($id); // Perform decryption If not successful then redirect to 404
        $Blog = Blog::findOrFail($id);
        return view('admin.blog.read_more', compact('Blog'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request){
        $blog_id = $this->decryptID($request->blog_id); // Perform decryption If not successful then redirect to 404
        $Blog = Blog::findOrFail($blog_id);
        $Title = $Blog->title;
        $Image = $Blog->image;
        $Description = $Blog->description;
        $Author = $Blog->author;
        $Publish_date = date('m/d/Y', strtotime($Blog->publish_date));

        return response()
            ->json(array('Id' => $blog_id , 'Title' => $Title, 'Image' =>$Image, 'Description' => $Description, 'Author'=>$Author, 'Publish_Date'=>$Publish_date), 200);
    }


    public function update_validate($request){
        Session::flash('Error_update', 'Create Error.');

        $request->validate([
            'title' => 'required|string|max:160|min:3',
            'edit_description' => ['required', new WordCountRule('Blog description',200,1000)],
            'image' => 'nullable|file|image|max:4096|mimes:jpg,jpeg,gif,JPG,JPEG,GIF',
            'author' => ['required','min:3','max:60', new NameValidate],
            'publish_date' => 'required|date',
        ], [
            'title.required' => 'Blog title is required.',
            'title.string' => 'Blog title should be a string.',
            'title.unique' => 'Blog title should be unique.',
            'title.max' => 'Blog title should be less then 160 letters.',
            'title.min' => 'Blog title should be more then 3 letters.',

            'edit_description.required' => 'Blog description is required.',

            'image.image' => 'Blog image must be a image file.',
            'image.file' => 'Blog image must be a image file.',
            'image.max' => 'Blog image must be less then 2048 Kb or 2 Mb.',
            'image.mimes' => 'Blog image can only contain jpg, jpeg and png file.',

            'author.required' => 'Author name is required.',
            'author.min' => 'Author name should be at-least 3 letters.',
            'author.max' => 'Author name should be less then 60 letters.',

            'publish_date.required' => 'Publish date is required.',
            'publish_date.date' => 'Publish date is not in correct format.',
            'publish_date.after' => 'Invalid blog publish date.',
        ]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->update_validate($request);

        $ID = trim($request->id);
        $title = ucwords(trim($request->title));
        $description = ucfirst(trim($request->edit_description));

        $Date = strtotime($request->publish_date); //Initial date format ....
        $Time = date('H:i:s'); // get current time ...
        $Publish_Date = date('Y/m/d '.$Time, $Date);

        $img_name = str_replace(array('?', '!', '.', ':', ' '), '-', $title);

        if($request->hasFile('image')){
            $get_image = $request->file('image'); // get the image form post method...
            $fileNameWithExt = $get_image->getClientOriginalName(); // get full file name ...
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME); // get only the file name without extension ....
            $extension = $get_image->getClientOriginalExtension();// get the file extension

            $allowed_Ext = array('jpg','jpeg', 'gif');
            if(in_array(strtolower($extension), $allowed_Ext, true) == false){
                return back()->withErrors('Error', 'Blog image can only contain jpg, jpeg and png file.');
            }
            //$fileNameToStore = $fileName.'_'.time().'.'.$extension;
            $newFileName = $img_name . '-' . time() . '.' . $extension; // Ste the file name to store in the database ....
            $Location = '/public/image/blog/';
            $get_image->storeAs($Location, $newFileName); // set the storage path ...
            $StorageLink = '/storage/image/blog/' . $newFileName;

            //Update Query ...
            Blog::findOrFail($ID)->update([
                'title' => $title,
                'image' => $StorageLink,
                'description' => $description,
                'author' => $request->author,
                'publish_date' => $Publish_Date,
                'updated_at' => Carbon::now(),
            ]);

        }
        else{
            Blog::findOrFail($ID)->update([
                'title' => $title,
                'description' => $description,
                'author' => $request->author,
                'publish_date' => $Publish_Date,
                'updated_at' => Carbon::now(),
            ]);
        }

        Session::forget('Error_update');
        //return Redirect::back();
        return back()->with('Success', 'Blog successfully updated.');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id = $this->decryptID($id); // Perform decryption If not successful then redirect to 404

        $Blog = Blog::onlyTrashed()->findOrFail($id);
        $Blog->forceDelete();
        Storage::delete($Blog->image);
        // Delete Comment
        BlogComment::where('blog_id', '=', $id)->forceDelete();
        // Delete View
        BlogView::where('blog_id', '=', $id)->forceDelete();

        return back()->with('deleted', 'Blog successfully deleted');
    }

    // soft delete blog
    public function softDelete($id){
        $id = $this->decryptID($id); // Perform decryption If not successful then redirect to 404
        Blog::withoutTrashed()->findOrFail($id)->delete();
        return back()->with('Success', 'Blog successfully deleted.');
    }

    // Restore deleted blog ...
    public function restore($id){
        $id = $this->decryptID($id); // Perform decryption If not successful then redirect to 404
        Blog::onlyTrashed()->findOrFail($id)->restore();
        return back()->with('Success', 'Blog successfully restored');
    }

    // Search Blog .... //
    public function search(Request $request){
        if($request->ajax()){
            $Output='';
            $Title = $request->blog_title;
            $Blogs = Blog::orderBy('title', 'ASC')->where('title', 'like', '%'.$Title.'%')->get();
            if(count($Blogs) > 0){
                foreach ($Blogs as $B){
                    $enc_id = encrypt($B->id);
                $Output .='
                <div class="col-lg-6 hideOnSearch">
                    <div class="Blog bg-muted bor-rad-10" style="padding: 10px; margin: 10px 0;">
                        <img src="'.$B->image.'" alt="blog image">
                        <div class="Details  truncate fh-200" style="height: 220px;">
                            <h3 class="text-left">'.$B->title.'</h3>
                            <p>By <a href="#">'.$B->author.'</a> | '.$B->publish_date.'</p>
                            <p>'.$this->description($B->description).'</p>
                        </div>
                        <div class="panel-footer">
                            <span> <a href="'.urlencode('blog-read-more|'.encrypt($B->id)).'" class="btn btn-primary btn-xs"><i class="fa fa-book-reader"></i> Read more</a></span>
                            <span style="margin-top: 2px!important; float: right; margin-bottom: 16px!important; display: block;">
                                <a href="#edit-form" data-toggle="modal" id="'.encrypt($B->id).'" class="btn btn-warning btn-xs Btn_Edit_Blog" onclick="fazil(this.id)">
                                <i class="fa fa-edit"></i> Edit </a> |
                                <a href="' .urlencode('soft-delete-blog|'.encrypt($B->id)).'" onclick="return deleteConfirmation()" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Delete</a>
                            </span>
                        </div>

                        <div class="Comment_view_Show">
                            <span> '.count($B->comment).' <i class="fa fa-comments"></i> Comments </span>
                            <span> '.count($B->view).' <i class="fa fa-eye"></i> Views </span>
                        </div>
                    </div>
                </div>
                ';
                }
            }
            else{
                $Output = '<div class="alert alert-danger text-center">No search result!</div>';
            }
            return response($Output);
        }
    }

    public function get_id($enc_id){
        return $enc_id;
    }

    // Print blog description part in output ....
    public function description($Description){
        $string = strip_tags($Description);
        if (strlen($string) > 20) {
            // truncate string
            $stringCut = substr($string, 0, 480);
            $endPoint = strrpos($stringCut, ' ');
            //if the string doesn't contain any space then it will cut without word basis.
            $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
            $string .= '... ';
        }
        return $string;
    }


    /*public function test(){
        $Title = 'nahid';
        $Blogs = Blog::orderBy('title', 'ASC')->where('title', 'like', '%'.$Title.'%')->get();
        foreach ($Blogs as $B){
            echo $B->title;
        }
    }*/
}
