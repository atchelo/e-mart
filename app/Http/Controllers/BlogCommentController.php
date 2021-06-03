<?php
namespace App\Http\Controllers;

use App\BlogComment;
use Illuminate\Http\Request;
use View;

/*==========================================
=            Author: Media City            =
    Author URI: https://mediacity.co.in
=            Author: Media City            =
=            Copyright (c) 2020            =
==========================================*/

class BlogCommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function loadmore(Request $request)
    {
        $id = $request->id;
        $proid = $request->proid;

        $comments = BlogComment::where('post_id', $proid)->where('id', '<', $id)->orderBy('created_at', 'DESC')
            ->limit(5)
            ->get();

        if (!$comments->isEmpty())
        {

            return View::make('front.blogmorecomment', compact('comments'))
                ->render();

        }
        else
        {
            $comments = NULL;
        }

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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {

        $input = $request->all();
        $newcomment = new BlogComment;
        $input['comment'] = clean($request->comment);
        $input['post_id'] = $id;
        $newcomment->create($input);
        notify()->success('Comment added successfully !');
        return back();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\BlogComment  $blogComment
     * @return \Illuminate\Http\Response
     */
    public function show(BlogComment $blogComment)
    {
        //
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\BlogComment  $blogComment
     * @return \Illuminate\Http\Response
     */
    public function edit(BlogComment $blogComment)
    {
        //
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\BlogComment  $blogComment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BlogComment $blogComment)
    {
        //
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\BlogComment  $blogComment
     * @return \Illuminate\Http\Response
     */
    public function destroy(BlogComment $blogComment)
    {
        //
        
    }
}

