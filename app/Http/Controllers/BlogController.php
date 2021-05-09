<?php

namespace App\Http\Controllers;

use App\Blog;
use App\BlogComment;
use App\BlogView;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
{
    /*public function __construct()
    {
        $this->middleware('auth');
    }*/

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Blog = Blog::orderBy('publish_date', 'DESC')->orderBy('id', 'DESC')->where('publish_date', '<', Carbon::now())->paginate(6);

        $TopBlog = Blog::with('view')->get()->sortBy(function($view) {
            return $view->view->count();
        })->reverse()->take(6);

        return view('pages.blog.blog', compact('Blog', 'TopBlog'));
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

        // view counter logic
        $ip = self::get_ip();
        if (Auth::check() && Auth::user()->is_admin !== 1 ){
            $Uid = Auth::user()->id;
            $find_user = BlogView::where('user_id', '=', $Uid)->where('blog_id', '=', $id)->get();
            if(count($find_user) <= 0){
                BlogView::Insert([
                    'ip_address' => $ip,
                    'blog_id' => $id,
                    'user_id' => $Uid,
                    'created_at' => Carbon::now(),
                ]);
            }
        }else{
            $find_ip = BlogView::where('ip_address', '=', $ip)->where('blog_id', '=', $id)->get();
            if(count($find_ip) <= 0){
                BlogView::Insert([
                    'ip_address' => $ip,
                    'blog_id' => $id,
                    'user_id' => 0,
                    'created_at' => Carbon::now(),
                ]);
            }
        }
        return view('pages.blog.single_blog', compact('Blog'));
    }


    public static function get_ip(){
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP'])){
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        } else if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else if(isset($_SERVER['HTTP_X_FORWARDED'])){
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        } else if(isset($_SERVER['HTTP_FORWARDED_FOR'])){
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        } else if(isset($_SERVER['HTTP_FORWARDED'])){
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        } else if(isset($_SERVER['REMOTE_ADDR'])){
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        } else{
            $ipaddress = 'UNKNOWN';
        }
        return $ipaddress;
    }


    // Search Blog .... //
    public function search(Request $request){
        if($request->ajax()){
            $Output='';
            $Title = $request->blog_title;
            $Blogs = Blog::orderBy('title', 'ASC')->where('title', 'like', '%'.$Title.'%')->where('publish_date', '<', Carbon::now())->get();
            //$Output = dd($Blogs);
            if(count($Blogs) > 0){
                foreach ($Blogs as $B){
                    $Output .='
                    <div class="col-12 top blog_bg">
                        <div class="blog_view_top">
                            <h2>'.$B->title.'</h2>
                        </div>
                        <div class="Blog_View_Content">
                            <img src="'.$B->image.'" alt="">
                            <div class="Blog_Description p-t-10">
                                <!-- Truncate blog description -->
                                '.$this->description($B->description).'
                            </div>
                            <a class="btn btn-dark m-t-10" href="'.urlencode('view-blog|' .encrypt($B->id)).'">READ MORE</a>
                        </div>
                        <div class="Blog_Footer">
                            <hr>
                            <span class="">
                                <i class="fas fa-user"></i><span class="m-l-6 m-r-6"> Author: '.$B->author.' </span> |
                                <i class="fas fa-calendar-alt m-l-6 m-r-6"></i> '.date('M-d-y',strtotime($B->publish_date)).'
                            </span>
                            <hr>
                            <span class="">
                                <span class="m-r-6"> '.count($B->comment).' <i class="fa fa-comments"></i> Comments </span> |
                                <span class="m-l-6"> '.count($B->view).' <i class="fa fa-eye"></i> Views </span>
                            </span>
                            <hr>
                        </div>
                    </div>
                    <br>';
                }
            }
            else{
                $Output = '<div class="alert alert-danger text-center">No search result!</div>';
            }
            return response($Output);
        }
    }


    public function description($Description){
        $string = strip_tags($Description);
        if (strlen($string) > 20) {
            // truncate string
            $stringCut = substr($string, 0, 440);
            $endPoint = strrpos($stringCut, ' ');
            //if the string doesn't contain any space then it will cut without word basis.
            $string = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
            $string .= '... ';
        }
        return $string;
    }
}
