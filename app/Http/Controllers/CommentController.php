<?php
namespace App\Http\Controllers;

use App\Comment;
use App\Subcomment;
use Avatar;
use Carbon\Carbon;
use Illuminate\Http\Request;
use View;

/*==========================================
=            Author: Media City            =
Author URI: https://mediacity.co.in
=            Author: Media City            =
=            Copyright (c) 2020            =
==========================================*/

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, array(
            'name' => 'required|max:100',
            'email' => 'required|email|max:250',
            'comment' => 'required|min:5|max:2000',
        ));

        $comment = new Comment();
        $comment->name = $request->name;
        $comment->email = $request->email;
        $comment->comment = clean($request->comment);
        $comment->approved = 1;
        $comment->pro_id = $request->id;

       $comment->save();

       notify()->success('Comment has been posted !');

       return back();

    }

    public function loadmore(Request $request)
    {

        $output = '';
        $id = $request->id;
        $proid = $request->proid;

        $comments = Comment::where('pro_id', $proid)->where('id', '<', $id)->orderBy('created_at', 'DESC')
            ->limit(5)
            ->get();

        if (count($comments)) {
            return response()->json(['cururl' => View::make('front.loadmorecomments', compact('comments','proid'))->render()]);
        }else{
            return response()->json("No comments found !");
        }

       
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
        $comment = Comment::find($id);
        $this->validate($request, array(
            'comment' => 'required',
        ));

        $comment->comment = clean($request->comment);
        $comment->save();

        Session::flash('success', 'Comment Updated Successfully');
        return redirect()
            ->route('posts.show', $comment
                    ->post
                    ->id);
        }

        public function destroy($id)
    {
        $comment = Comment::find($id);
        $comment->delete();
        Session::flash('success', 'Comment Deleted');
        $post_id = $comment
            ->post->id;
        return redirect()
            ->route('posts.show', $post_id);
    }

    public function ajex_submit(Request $request)
    {

        $comment = new Subcomment();
        $comment->comment_id = $request->id;
        $comment->comment = clean($request->comment);
        $comment->approved = 1;
        $check = $comment->save();

        $arr = array(
            'success' => 'Something goes to wrong. Please try again lator',
            'status' => false,
        );
        if ($check) {
            $arr = array(
                'success' => 'Successfully submit form using ajax',
                'status' => true,
                'msg' => $request->comment,
            );

        }

        return Response()
            ->json($arr);

    }

}
