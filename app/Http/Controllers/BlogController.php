<?php
namespace App\Http\Controllers;

use App\Blog;
use App\BlogComment;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Image;

/*==========================================
=            Author: Media City            =
Author URI: https://mediacity.co.in
=            Developer: @nkit              =
=            Copyright (c) 2020            =
==========================================*/

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $blogs = Blog::all();
        return view('admindesk.blog.index', compact('blogs'));
    }

    public function search(Request $request)
    {

        $search = $request->search;
        $result = array();
        $query = Blog::where('heading', 'LIKE', '%' . $search . '%')->get();
        $infourl = url('images');
        $imageurl = url('images/blog');
        if (count($query) > 0) {

            foreach ($query as $key => $q) {
                $result[] = ['slug' => $q->slug, 'img' => $imageurl . '/' . $q->image, 'value' => $q->heading];
            }

        } else {

            $result[] = ['slug' => '#', 'img' => $infourl . '/info.png', 'value' => 'No Result found'];

        }

        return response()->json($result);

    }

    public function frontindex()
    {
        require_once 'price.php';
        $blogs = Blog::orderBy('id', 'DESC')->where('status', '1')
            ->paginate(5);

        $popularpost = collect();

        $allposts = Blog::orderByUniqueViews()->get();

        foreach ($allposts as $key => $post) {

            if (views($post)->unique()
                ->count() > 500) {

                $popularpost->push($post);

            }

        }

        return view('front.blogindex', compact('blogs', 'conversion_rate', 'popularpost'));

    }

    public function show($slug)
    {
        require_once 'price.php';

        $value = Blog::where('slug', '=', $slug)->where('status', '=', '1')->first();

        

        $popularpost = collect();

        $allposts = Blog::orderByUniqueViews()->get();

        foreach ($allposts as $key => $post) {

            if (views($post)->unique()->count() > 500) {

                $popularpost->push($post);

            }

        }

        if (isset($value)) {

            views($value)->record();

            return view('front.blog', compact('value', 'conversion_rate', 'popularpost'));

        } else {
            notify()->error('Blog post not found or not active');
            return redirect('/');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admindesk.blog.add");
    }

    public function loadcommentsOneditpost(Request $request, $id)
    {

        $post = Blog::findorfail($id);

        $comments = $post->comments;

        if ($request->ajax()) {
            return DataTables::of($comments)->addIndexColumn()->addColumn('comment', function ($row) {
                $html = '';
                $html .= str_limit(strip_tags($row->comment), 100);
                if (strlen(strip_tags($row->comment)) > 100) {
                    $html .= '...';
                }

                return $html;
            })->editColumn('action', 'admindesk.blog.commentaction')
                ->rawColumns(['comment', 'action'])
                ->make(true);
        }

    }

    public function deletecomment($id)
    {
        $comment = BlogComment::find($id);

        if (isset($comment)) {
            $comment->delete();
            return back()
                ->with('deleted', 'Comment deleted successfully !');
        } else {
            return back()
                ->with('warning', '404 Comment not found !');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([

            "heading" => "required", 'user' => 'required|not_in:0',

            'image' => 'required | max:1000'], [

            "heading.required" => "Slider heading is required", "user.required" => "User name is required",

        ]);

        $blog = new Blog;

        $input = $request->all();

        $input['des'] = clean($request->des);

        $input['slug'] = Str::slug($request->heading, '-');

        if ($file = $request->file('image')) {

            $optimizeImage = Image::make($file);
            $optimizePath = public_path() . '/images/blog/';
            $image = time() . $file->getClientOriginalName();
            $optimizeImage->save($optimizePath . $image);
            $optimizeImage->fit(1075, 400, function ($constraint) {
                $constraint->aspectRatio();
            });
            $input['image'] = $image;

        }

        $blog->create($input);

        return back()->with("added", "Blog Has Been Created !");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $blog = Blog::findOrFail($id);
        return view('admindesk.blog.edit', compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $slider = Blog::findOrFail($id);
        $input = $request->all();

        if ($file = $request->file('image')) {

            if ($slider->image != null && file_exists(public_path() . '/images/blog/' . $slider->image)) {
                unlink(public_path() . '/images/blog/' . $slider->image);
            }

            $optimizeImage = Image::make($file);
            $optimizePath = public_path() . '/images/blog/';
            $name = time() . $file->getClientOriginalName();

            $optimizeImage->fit(1075, 400, function ($constraint) {
                $constraint->aspectRatio();
            });

            $optimizeImage->save($optimizePath . $name);

            $input['image'] = $name;

        }

        $input['des'] = clean($request->des);
        $input['slug'] = Str::slug($request->heading, '-');

        $slider->update($input);

        return redirect('admindesk/blog')->with('updated', 'Blog post has been updated !');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cat = Blog::find($id);
        $value = $cat->delete();
        if ($value) {
            session()->flash("deleted", "Blog Has Been Deleted");
            return redirect("admindesk/blog");
        }
    }
}
