<?php

namespace App\Http\Controllers;

use App\BlogComment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    // comment system ...
    public function loadComment(Request $request)
    {
        $blog_id = $request->bid;
        function loop_comment($blog_id, $parent_id = null, $margin_left = 0)
        {
            $Child_comment = BlogComment::where('blog_id', '=', $blog_id)
                ->join('users', 'users.id', '=', 'blog_comments.user_id')
                ->where('blog_comments.parent_id', '=', $parent_id)
                ->orderBy('blog_comments.created_at', 'ASC')
                ->select('users.first_name', 'users.last_name', 'users.id as user_id', 'users.avatar', 'users.email',
                    'blog_comments.id as comment_id', 'blog_comments.parent_id', 'blog_comments.comment',
                    'blog_comments.blog_id', 'blog_comments.created_at')
                ->get();
            $Output = '';
            if ($parent_id == null) {
                $margin_left = 0;
            } else {
                $margin_left += 50;
            }
            if (count($Child_comment) > 0) {
                foreach ($Child_comment as $r) {
                    // Triple equal causes problem ...
                    /*if ($r->user_id !== Auth::user()->id) {
                        $Reply_Btn = '';
                    } else {
                        $Reply_Btn = '';
                    }*/
                    if ($r->user_id == Auth::user()->id) {
                        $Edit_Btn = '<button class="btn btn-sm btn-warning Edit_Comment_Btn"  data-id="' . encrypt($r->comment_id) . '" title="Edit"><i class="fa fa-edit"></i></button>';
                    } else {
                        $Edit_Btn = '';
                    }
                    if(Auth::user()->is_admin == 1){
                        $Delete_Btn = '<button class="btn btn-sm btn-danger Delete_Comment_Btn" data-id="' . encrypt($r->comment_id) . '" title="Delete">
                                    <i class="fa fa-trash"></i>
                                    </button>';
                    } else{
                        $Delete_Btn = '';
                    }
                    $Output .= '
                    <div class="m-t-6 m-b-6 comment_single rounded" style="padding: 4px 10px; position: relative; margin-left:' . $margin_left . 'px;background: #d9d9d9;">
                        <div class="">
                        <a href="' . urlencode('view-profile|' . encrypt($r->uuser_id)) . '">
                            <img alt="" src="' . $r->avatar . '" class="rounded-circle shadow-lg m-b-4" height="50" width="50" style="box-shadow: 0 0 6px rgba(0,0,0,.6);object-fit: cover;object-position: center top;">
                            <span class="m-l-sm" style="color: #0077f7 ;font-size: 12px;"><b>' . $r->first_name . ' ' . $r->last_name . '</b></span>
                        </a>
                        <span style="font-size: 12px; margin-left: 15px;">' . ucfirst($r->comment) . '</span>
                        <div class="btn-group btn-group-sm comment_btns" role="group" style="position: absolute;right: 6px;">
                            <button class="Reply push- btn btn-sm btn-primary" data-id="' . $r->comment_id . '" data-name="' . $r->first_name . ' ' . $r->last_name . '" title="Reply">
                            <i class="fas fa-reply"></i>
                            </button>
                            ' . $Edit_Btn . $Delete_Btn . '
                        </div>
                        <div style="font-size: 12px">
                            ' . date('d.m.Y - h:i a', strtotime($r->created_at)) . '
                        </div>
                        </div>
                    </div>';
                    $Output .= loop_comment($blog_id, $r->comment_id, $margin_left);
                }
            }
            //return $Output;
            return response($Output);
        }


        // .... View comment .... //
        if ($request->ajax()) {
            $blog_id = $request->bid;
            $Parent_comment = BlogComment::where('blog_id', '=', $blog_id)
                ->join('users', 'users.id', '=', 'blog_comments.user_id')
                ->where('parent_id', '=', null)
                ->orderBy('blog_comments.created_at', 'DESC')
                ->select('users.first_name', 'users.last_name', 'users.id as user_id', 'users.avatar', 'users.email',
                    'blog_comments.id as comment_id', 'blog_comments.parent_id', 'blog_comments.comment',
                    'blog_comments.blog_id', 'blog_comments.created_at')
                ->get();
            $Output = '';

            if (count($Parent_comment) > 0) {
                foreach ($Parent_comment as $rows) {
                    // Triple equal causes problem ...
                    /*if ($rows->user_id !== Auth::user()->id) {
                        $Reply_Btn = '';
                    } else {
                        $Reply_Btn = '';
                    }*/
                    if ($rows->user_id == Auth::user()->id) {
                        $Edit_Btn = '<button class="btn btn-sm btn-warning Edit_Comment_Btn" data-id="' . encrypt($rows->comment_id) . '" title="Edit"><i class="fa fa-edit"></i></button>';
                    } else {
                        $Edit_Btn = '';
                    }
                    if(Auth::user()->is_admin == 1){
                        $Delete_Btn = '<button class="btn btn-sm btn-danger Delete_Comment_Btn" data-id="' . encrypt($rows->comment_id) . '" title="Delete">
                                        <i class="fa fa-trash"></i>
                                        </button>';
                    } else{
                        $Delete_Btn = '';
                    }

                    $Output .= '
                    <div class="m-t-6 m-b-6 bg-white comment_single rounded">
                        <div class="">
                            <a href="' . urlencode('view-profile|' . encrypt($rows->uuser_id)) . '">
                                <img alt="" src="' . $rows->avatar . '" class="rounded-circle shadow-lg m-b-4" height="50" width="50" style="box-shadow: 0 0 6px rgba(0,0,0,.6);">
                                <span class="m-l-sm" style="color: #0077f7;font-size: 12px;"><b>' . $rows->first_name . ' ' . $rows->last_name . '</b></span>
                            </a>
                            <span style="font-size: 12px; margin-left: 15px;">' . htmlspecialchars(ucfirst($rows->comment)) . '</span>
                            <div class="btn-group btn-group-sm comment_btns" role="group" >
                                <button class="Reply push- btn btn-sm btn-primary" data-id="' . $rows->comment_id . '" data-name="' . $rows->first_name . ' ' . $rows->last_name . '" title="Reply">
                                <i class="fas fa-reply"></i>
                                </button>
                                ' . $Edit_Btn . $Delete_Btn . '
                            </div>
                            <div style="font-size: 12px">
                                ' . date('d.m.Y - h:i a', strtotime($rows->created_at)) . '
                            </div>
                        </div>
                    </div>';
                    $Output .= loop_comment($blog_id, $rows->comment_id, 0);
                }
                return response($Output);
            } else {
                echo '<div class="text-center">No comment yet.... Be the first one to comment.</div>';
            }
        } else {
            echo '<div class="text-center">No comment yet.... Be the first one to comment.</div>';
        }
    }











    /// Add comment ...
    public function store(Request $request){
        $request->validate([
            'Comment_details' => 'required|string',
            'blog_id' => 'required',
            'user_id' => 'required',
            'parent_comment_id' => 'sometimes|nullable',
        ]);

        if($request->parent_comment_id == null){
            $parent = null;
        }else{
            $parent = $request->parent_comment_id;
        }
        if($request->ajax()) {
            $Success = BlogComment::Insert([
                'comment' => ucfirst($request->Comment_details),
                'blog_id' => decrypt($request->blog_id),
                'user_id' => decrypt($request->user_id),
                'parent_id' => $parent,
                'created_at' => Carbon::now(),
            ]);
        }
        //$Success = 'Data success';
        return response()->json($Success);
    }



    /*public function test ($blog_id){
        $Parent_comment = BlogComment::where('blog_id' , '=', $blog_id)
            ->join('users', 'users.id', '=' ,'blog_comments.user_id')
            ->where('parent_id', '=', null)
            ->orderBy('blog_comments.created_at', 'DESC')
            ->select('users.first_name','users.last_name', 'users.id as user_id', 'users.avatar', 'users.email',
                'blog_comments.id as comment_id', 'blog_comments.parent_id', 'blog_comments.comment',
                'blog_comments.blog_id', 'blog_comments.created_at')
            ->get();
        foreach ($Parent_comment as $P){
            echo $P->comment . '<br>';
        }
        dd($Parent_comment);
    }*/




    // Delete Comment ...
    public function delete($id){
        $id = $this->decryptID($id); // Perform decryption If not successful then redirect to 404
        BlogComment::withoutTrashed()->findOrFail($id)->delete();
        return response()->json( 'Blog successfully deleted.');
    }

    // Edit Comment ...
    public function edit($id){
        $id = $this->decryptID($id); // Perform decryption If not successful then redirect to 404
        $BlogComment = BlogComment::findOrFail($id);
        $Comment = $BlogComment->comment;

        return response()->json(array('Comment' => $Comment), 200);
    }

    // update Comment ...
    public function update(Request $request){
        /*$request->validate([
            'Comment_details' => 'required|string',
            'blog_id' => 'required',
            'user_id' => 'required',
            'comment_id' => 'required',
        ]);*/

        //$ID = trim(decrypt($request->comment_id));
        $ID = $this->decryptID($request->comment_id); // Perform decryption If not successful then redirect to 404


        $blog_id = $this->decryptID($request->blog_id); // Perform decryption If not successful then redirect to 404
        $user_id = $this->decryptID($request->user_id); // Perform decryption If not successful then redirect to 404

        if($request->ajax()) {
            $Success = BlogComment::findOrFail($ID)->update([
                'comment' => ucfirst($request->Comment_details),
                'blog_id' => $blog_id,
                'user_id' => $user_id,
                'comment_id' => $request->comment_id,
                'updated_at' => Carbon::now(),
            ]);
        }
        //$Success = 'Data success';
        return response()->json($Success);
    }
}
