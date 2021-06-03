<?php
namespace App\Http\Controllers;

use App\Adv;
use DataTables;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use View;

/*==========================================
=            Author: Media City            =
Author URI: https://mediacity.co.in
=            Developer: @nkit              =
=            Copyright (c) 2020            =
==========================================*/

class AdvController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $adv = Adv::select('id', 'layout', 'position', 'status')->get();

        if ($request->ajax()) {

            return DataTables::of($adv)
                ->addIndexColumn()->addColumn('layout', function ($row) {
                return $row->layout;
            })->addColumn('pos', function ($row) {
                if ($row->position == 'beforeslider') {
                    return $position = 'Before Slider';
                } else if ($row->position == 'abovenewproduct') {
                    return $position = 'Above New Product Widget';
                } else if ($row->position == 'abovetopcategory') {
                    return $position = 'Above Top Category Widget';
                } else if ($row->position == 'abovelatestblog') {
                    return $position = 'Above Blog Widget';
                } else if ($row->position == 'abovefeaturedproduct') {
                    return $position = 'Above Featured Product Widget';
                } else if ($row->position == 'afterfeaturedproduct') {
                    return $position = 'After Featured Product Widget';
                }
            })
                ->addColumn('status', 'admindesk.adv.status')
                ->addColumn('action', 'admindesk.adv.action')
                ->rawColumns(['layout', 'pos', 'status', 'action'])
                ->make(true);
        }

        return view("admindesk.adv.index", compact("adv"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("admindesk.adv.add");
    }

    public function selectLayout(Request $request)
    {
        $request->validate(['layout' => 'required'], ['layout.required' => 'Select a layout first !']);

        if (isset($request->layout)) {
            $layout = ucfirst($request->layout);
            if ($layout == 'Three Image Layout' || $layout == 'Two non equal image layout' || $layout == 'Two equal image layout' || $layout == 'Single image layout') {

                return view('admindesk.adv.layout', compact('layout'));
            } else {

                return redirect()->route('adv.create')
                    ->with('warning', '404 ! Layout not found !');
            }

        } else {
            return redirect()
                ->route('adv.create')
                ->with('warning', 'Layout not selected !');
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

        $layout = $request->layout;
        $newadv = new Adv;
        $input = $request->all();
        $input['layout'] = $layout;
        $input['position'] = $request->position;

        if (isset($request->status)) {
            $input['status'] = 1;
        } else {
            $input['status'] = 0;
        }

        if ($layout == 'Three Image Layout') {

            if ($file = $request->file('image1')) {
                
                $img = Image::make($file);

                $destinationPath = public_path() . '/images/layoutads/';

                $name = time() . $file->getClientOriginalName();

                $img->resize(396, 396, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $img->save($destinationPath . $name);
                $input['image1'] = $name;

            }

            if ($file = $request->file('image2')) {

                $img = Image::make($file);

                $destinationPath = public_path() . '/images/layoutads/';

                $name = time() . $file->getClientOriginalName();

                $img->resize(396, 396, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $img->save($destinationPath . $name);
                $input['image2'] = $name;
            }

            if ($file = $request->file('image3')) {

                $img = Image::make($file);

                $destinationPath = public_path() . '/images/layoutads/';

                $name = time() . $file->getClientOriginalName();

                $img->resize(396, 396, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $img->save($destinationPath . $name);
                $input['image3'] = $name;
            }

            if ($request->img1linkby == 'linkbycat') {
                $input['cat_id1'] = $request->cat_id1;
                $input['pro_id1'] = null;
                $input['url1'] = null;
            } elseif ($request->img2linkby == 'linkbypro') {
                $input['pro_id1'] = $request->pro_id1;
                $input['cat_id1'] = null;
                $input['url1'] = null;
            } elseif ($request->img2linkby == 'linkbyurl') {
                $input['pro_id1'] = null;
                $input['cat_id1'] = null;
                $input['url1'] = $request->url1;
            }

            if ($request->img2linkby == 'linkbycat') {
                $input['cat_id2'] = $request->cat_id2;
                $input['pro_id2'] = null;
                $input['url2'] = null;
            } elseif ($request->img2linkby == 'linkbypro') {
                $input['pro_id2'] = $request->pro_id2;
                $input['cat_id2'] = null;
                $input['url2'] = null;
            } elseif ($request->img2linkby == 'linkbyurl') {
                $input['pro_id2'] = null;
                $input['cat_id2'] = null;
                $input['url2'] = $request->url2;
            }

            if ($request->img3linkby == 'linkbycat') {
                $input['cat_id3'] = $request->cat_id3;
                $input['pro_id3'] = null;
                $input['url3'] = null;
            } elseif ($request->img3linkby == 'linkbypro') {
                $input['pro_id3'] = $request->pro_id3;
                $input['cat_id3'] = null;
                $input['url3'] = null;
            } elseif ($request->img3linkby == 'linkbyurl') {
                $input['pro_id3'] = null;
                $input['cat_id3'] = null;
                $input['url3'] = $request->url3;
            }

        } elseif ($layout == 'Two non equal image layout') {

            if ($file = $request->file('image1')) {

                $name = time() . $file->getClientOriginalName();
                $file->move('images/adv', $name);
                $input['image1'] = $name;
            }

            if ($file = $request->file('image2')) {

                $name = time() . $file->getClientOriginalName();
                $file->move('images/adv', $name);
                $input['image2'] = $name;
            }

            if ($request->img1linkby == 'linkbycat') {
                $input['cat_id1'] = $request->cat_id1;
                $input['pro_id1'] = null;
                $input['url1'] = null;
            } elseif ($request->img2linkby == 'linkbypro') {
                $input['pro_id1'] = $request->pro_id1;
                $input['cat_id1'] = null;
                $input['url1'] = null;
            } elseif ($request->img2linkby == 'linkbyurl') {
                $input['pro_id1'] = null;
                $input['cat_id1'] = null;
                $input['url1'] = $request->url1;
            }

            if ($request->img2linkby == 'linkbycat') {
                $input['cat_id2'] = $request->cat_id2;
                $input['pro_id2'] = null;
                $input['url2'] = null;
            } elseif ($request->img2linkby == 'linkbypro') {
                $input['pro_id2'] = $request->pro_id2;
                $input['cat_id2'] = null;
                $input['url2'] = null;
            } elseif ($request->img2linkby == 'linkbyurl') {
                $input['pro_id2'] = null;
                $input['cat_id2'] = null;
                $input['url2'] = $request->url2;
            }

        } elseif ($layout == 'Two equal image layout') {

            if ($file = $request->file('image1')) {

                $img = Image::make($file);

                $destinationPath = public_path() . '/images/layoutads/';

                $name = time() . $file->getClientOriginalName();

                $img->resize(822, 303, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $img->save($destinationPath . $name);
                $input['image1'] = $name;
            }

            if ($file = $request->file('image2')) {

                 $img = Image::make($file);

                $destinationPath = public_path() . '/images/layoutads/';

                $name = time() . $file->getClientOriginalName();

                $img->resize(396, 303, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $img->save($destinationPath . $name);
                $input['image2'] = $name;
            }

            if ($request->img1linkby == 'linkbycat') {
                $input['cat_id1'] = $request->cat_id1;
                $input['pro_id1'] = null;
                $input['url1'] = null;
            } elseif ($request->img2linkby == 'linkbypro') {
                $input['pro_id1'] = $request->pro_id1;
                $input['cat_id1'] = null;
                $input['url1'] = null;
            } elseif ($request->img2linkby == 'linkbyurl') {
                $input['pro_id1'] = null;
                $input['cat_id1'] = null;
                $input['url1'] = $request->url1;
            }

            if ($request->img2linkby == 'linkbycat') {
                $input['cat_id2'] = $request->cat_id2;
                $input['pro_id2'] = null;
                $input['url2'] = null;
            } elseif ($request->img2linkby == 'linkbypro') {
                $input['pro_id2'] = $request->pro_id2;
                $input['cat_id2'] = null;
                $input['url2'] = null;
            } elseif ($request->img2linkby == 'linkbyurl') {
                $input['pro_id2'] = null;
                $input['cat_id2'] = null;
                $input['url2'] = $request->url2;
            }
        } elseif ($layout == 'Single image layout') {

            if ($file = $request->file('image1')) {

                $img = Image::make($file);

                $destinationPath = public_path() . '/images/layoutads/';

                $name = time() . $file->getClientOriginalName();

                $img->resize(1247, 520, function ($constraint) {
                    $constraint->aspectRatio();
                });

                $img->save($destinationPath . $name);
                $input['image1'] = $name;
            }

            if ($request->img1linkby == 'linkbycat') {
                $input['cat_id1'] = $request->cat_id1;
                $input['pro_id1'] = null;
                $input['url1'] = null;
            } elseif ($request->img2linkby == 'linkbypro') {
                $input['pro_id1'] = $request->pro_id1;
                $input['cat_id1'] = null;
                $input['url1'] = null;
            } elseif ($request->img2linkby == 'linkbyurl') {
                $input['pro_id1'] = null;
                $input['cat_id1'] = null;
                $input['url1'] = $request->url1;
            }

        } else {
            return redirect()
                ->route('adv.create')
                ->with('warning', 'Invalid Layout !');
        }

        $newadv->create($input);
        return redirect()->route('adv.index')
            ->with("added", "Advertisement Has Been Created !");
    }

    public function edit($id)
    {
        $adv = Adv::find($id);
        return view("admindesk.adv.edit", compact("adv"));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\adv  $adv
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $adv = Adv::find($id);

        if (isset($adv)) {

            $layout = $adv->layout;
            $input = $request->all();
            $input['layout'] = $layout;
            $input['position'] = $request->position;

            if (isset($request->status)) {
                $input['status'] = 1;
            } else {
                $input['status'] = 0;
            }

            if ($layout == 'Three Image Layout') {

                if ($file = $request->file('image1')) {

                    if ($adv->image1 !='' && file_exists(public_path() . '/images/layoutads/' . $adv->image1)) {
                        unlink(public_path() . '/images/layoutads/' . $adv->image1);
                    }

                    $img = Image::make($file);

                    $destinationPath = public_path() . '/images/layoutads/';

                    $name = time() . $file->getClientOriginalName();

                    $img->resize(396, 396, function ($constraint) {
                        $constraint->aspectRatio();
                    });

                    $img->save($destinationPath . $name);
                    $input['image1'] = $name;
                }

                if ($file = $request->file('image2')) {

                    if ($adv->image2 !='' && file_exists(public_path() . '/images/layoutads/' . $adv->image2)) {
                        unlink(public_path() . '/images/layoutads/' . $adv->image2);
                    }

                    $img = Image::make($file);

                    $destinationPath = public_path() . '/images/layoutads/';

                    $name = time() . $file->getClientOriginalName();

                    $img->resize(396, 396, function ($constraint) {
                        $constraint->aspectRatio();
                    });

                    $img->save($destinationPath . $name);
                    $input['image2'] = $name;
                }

                if ($file = $request->file('image3')) {

                    if ($adv->image3 !='' && file_exists(public_path() . '/images/layoutads/' . $adv->image3)) {
                        unlink(public_path() . '/images/layoutads/' . $adv->image3);
                    }

                    $img = Image::make($file);
                    $destinationPath = public_path() . '/images/layoutads/';
                    $name = time() . $file->getClientOriginalName();
                    $img->resize(396, 396, function ($constraint) {
                        $constraint->aspectRatio();
                    });

                    $img->save($destinationPath . $name);
                    $input['image3'] = $name;
                }

                if ($request->img1linkby == 'linkbycat') {
                    $input['cat_id1'] = $request->cat_id1;
                    $input['pro_id1'] = null;
                    $input['url1'] = null;
                } elseif ($request->img1linkby == 'linkbypro') {
                    $input['pro_id1'] = $request->pro_id1;
                    $input['cat_id1'] = null;
                    $input['url1'] = null;
                } elseif ($request->img1linkby == 'linkbyurl') {
                    $input['pro_id1'] = null;
                    $input['cat_id1'] = null;
                    $input['url1'] = $request->url1;
                }

                if ($request->img2linkby == 'linkbycat') {
                    $input['cat_id2'] = $request->cat_id2;
                    $input['pro_id2'] = null;
                    $input['url2'] = null;
                } elseif ($request->img2linkby == 'linkbypro') {
                    $input['pro_id2'] = $request->pro_id2;
                    $input['cat_id2'] = null;
                    $input['url2'] = null;
                } elseif ($request->img2linkby == 'linkbyurl') {
                    $input['pro_id2'] = null;
                    $input['cat_id2'] = null;
                    $input['url2'] = $request->url2;
                }

                if ($request->img3linkby == 'linkbycat') {
                    $input['cat_id3'] = $request->cat_id3;
                    $input['pro_id3'] = null;
                    $input['url3'] = null;
                } elseif ($request->img3linkby == 'linkbypro') {
                    $input['pro_id3'] = $request->pro_id3;
                    $input['cat_id3'] = null;
                    $input['url3'] = null;
                } elseif ($request->img3linkby == 'linkbyurl') {
                    $input['pro_id3'] = null;
                    $input['cat_id3'] = null;
                    $input['url3'] = $request->url3;
                }

            } elseif ($layout == 'Two non equal image layout') {

                if ($file = $request->file('image1')) {

                    if ($adv->image1 !='' && file_exists(public_path() . '/images/layoutads/' . $adv->image1)) {
                        unlink(public_path() . '/images/layoutads/' . $adv->image1);
                    }

                    $img = Image::make($file);

                    $destinationPath = public_path() . '/images/layoutads/';

                    $name = time() . $file->getClientOriginalName();

                    $img->resize(822, 303, function ($constraint) {
                        $constraint->aspectRatio();
                    });

                    $img->save($destinationPath . $name, 90);
                    $input['image1'] = $name;
                }

                if ($file = $request->file('image2')) {
                    if ($adv->image2 !='' && file_exists(public_path() . '/images/layoutads/' . $adv->image2)) {
                        unlink(public_path() . '/images/layoutads/' . $adv->image2);
                    }

                    $img = Image::make($file);

                    $destinationPath = public_path() . '/images/layoutads/';

                    $name = time() . $file->getClientOriginalName();

                    $img->resize(396, 396, function ($constraint) {
                        $constraint->aspectRatio();
                    });

                    $img->save($destinationPath . $name, 90);
                    $input['image2'] = $name;
                }

                if ($request->img1linkby == 'linkbycat') {
                    $input['cat_id1'] = $request->cat_id1;
                    $input['pro_id1'] = null;
                    $input['url1'] = null;
                } elseif ($request->img1linkby == 'linkbypro') {
                    $input['pro_id1'] = $request->pro_id1;
                    $input['cat_id1'] = null;
                    $input['url1'] = null;
                } elseif ($request->img1linkby == 'linkbyurl') {
                    $input['pro_id1'] = null;
                    $input['cat_id1'] = null;
                    $input['url1'] = $request->url1;
                }

                if ($request->img2linkby == 'linkbycat') {
                    $input['cat_id2'] = $request->cat_id2;
                    $input['pro_id2'] = null;
                    $input['url2'] = null;
                } elseif ($request->img2linkby == 'linkbypro') {
                    $input['pro_id2'] = $request->pro_id2;
                    $input['cat_id2'] = null;
                    $input['url2'] = null;
                } elseif ($request->img2linkby == 'linkbyurl') {
                    $input['pro_id2'] = null;
                    $input['cat_id2'] = null;
                    $input['url2'] = $request->url2;
                }

            } elseif ($layout == 'Two equal image layout') {

                if ($file = $request->file('image1')) {

                    if ($adv->image1 !='' && file_exists(public_path() . '/images/layoutads/' . $adv->image1)) {
                        unlink(public_path() . '/images/layoutads/' . $adv->image1);
                    }

                    $img = Image::make($file);

                    $destinationPath = public_path() . '/images/layoutads/';

                    $name = time() . $file->getClientOriginalName();

                    $img->resize(609, 342, function ($constraint) {
                        $constraint->aspectRatio();
                    });

                    $img->save($destinationPath . $name, 90);
                    $input['image1'] = $name;
                }

                if ($file = $request->file('image2')) {
                    if ($adv->image2 !='' && file_exists(public_path() . '/images/layoutads/' . $adv->image2)) {
                        unlink(public_path() . '/images/layoutads/' . $adv->image2);
                    }

                    $img = Image::make($file);

                    $destinationPath = public_path() . '/images/layoutads/';

                    $name = time() . $file->getClientOriginalName();

                    $img->resize(609, 342, function ($constraint) {
                        $constraint->aspectRatio();
                    });

                    $img->save($destinationPath . $name, 90);
                    $input['image2'] = $name;
                }

                if ($request->img1linkby == 'linkbycat') {
                    $input['cat_id1'] = $request->cat_id1;
                    $input['pro_id1'] = null;
                    $input['url1'] = null;
                } elseif ($request->img1linkby == 'linkbypro') {
                    $input['pro_id1'] = $request->pro_id1;
                    $input['cat_id1'] = null;
                    $input['url1'] = null;
                } elseif ($request->img1linkby == 'linkbyurl') {
                    $input['pro_id1'] = null;
                    $input['cat_id1'] = null;
                    $input['url1'] = $request->url1;
                }

                if ($request->img2linkby == 'linkbycat') {
                    $input['cat_id2'] = $request->cat_id2;
                    $input['pro_id2'] = null;
                    $input['url2'] = null;
                } elseif ($request->img2linkby == 'linkbypro') {
                    $input['pro_id2'] = $request->pro_id2;
                    $input['cat_id2'] = null;
                    $input['url2'] = null;
                } elseif ($request->img2linkby == 'linkbyurl') {
                    $input['pro_id2'] = null;
                    $input['cat_id2'] = null;
                    $input['url2'] = $request->url2;
                }
            } elseif ($layout == 'Single image layout') {

                if ($file = $request->file('image1')) {

                    if ($adv->image1 !='' && file_exists(public_path() . '/images/layoutads/' . $adv->image1)) {
                        unlink(public_path() . '/images/layoutads/' . $adv->image1);
                    }

                    $img = Image::make($file);

                    $destinationPath = public_path() . '/images/layoutads/';

                    $name = time() . $file->getClientOriginalName();

                    $img->resize(1247, 520, function ($constraint) {
                        $constraint->aspectRatio();
                    });

                    $img->save($destinationPath . $name, 90);
                    $input['image1'] = $name;

                }

                if ($request->img1linkby == 'linkbycat') {

                    $input['cat_id1'] = $request->cat_id1;
                    $input['pro_id1'] = null;
                    $input['url1'] = null;
                } elseif ($request->img1linkby == 'linkbypro') {

                    $input['pro_id1'] = $request->pro_id1;
                    $input['cat_id1'] = null;
                    $input['url1'] = null;
                } elseif ($request->img1linkby == 'linkbyurl') {
                    $input['pro_id1'] = null;
                    $input['cat_id1'] = null;
                    $input['url1'] = $request->url1;
                }

            } else {
                return redirect()
                    ->route('adv.create')
                    ->with('warning', 'Invalid Layout !');
            }

            $adv->update($input);
            return redirect()->route('adv.index')
                ->with("added", "Advertisement Has Been Updated !");

        } else {
            return redirect()
                ->route('adv.index')
                ->with('warning', '404 Adv Not found !');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\adv  $adv
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $adv = Adv::find($id);

        if (isset($adv)) {
            if ($adv->layout == 'Three Image Layout') {

                if ($adv->image1 != '') {
                    if (file_exists(public_path() . '/images/layoutads/' . $adv->image1)) {
                        unlink(public_path() . '/images/layoutads/' . $adv->image1);
                    }
                }

                if ($adv->image2 != '') {
                    if (file_exists(public_path() . '/images/layoutads/' . $adv->image2)) {
                        unlink(public_path() . '/images/layoutads/' . $adv->image2);
                    }
                }

                if ($adv->image3 != '') {
                    if (file_exists(public_path() . '/images/layoutads/' . $adv->image3)) {
                        unlink(public_path() . '/images/layoutads/' . $adv->image3);
                    }
                }

            } else if ($adv->layout == 'Two non equal image layout') {

                if ($adv->image1 != '') {

                    if (file_exists(public_path() . '/images/layoutads/' . $adv->image1)) {
                        unlink(public_path() . '/images/layoutads/' . $adv->image1);
                    }

                }

                if ($adv->image2 != '') {
                    if (file_exists(public_path() . '/images/layoutads/' . $adv->image2)) {
                        unlink(public_path() . '/images/layoutads/' . $adv->image2);
                    }
                }

            } else if ($adv->layout == 'Two Equal Image Layout') {
                if ($adv->image1 != '') {
                    if (file_exists(public_path() . '/images/layoutads/' . $adv->image1)) {
                        unlink(public_path() . '/images/layoutads/' . $adv->image1);
                    }
                }

                if ($adv->image2 != '') {
                    if (file_exists(public_path() . '/images/layoutads/' . $adv->image2)) {
                        unlink(public_path() . '/images/layoutads/' . $adv->image2);
                    }
                }

            } else if ($adv->layout == 'Single Image Layout') {

                if ($adv->image1 != '') {
                    if (file_exists(public_path() . '/images/layoutads/' . $adv->image1)) {
                        unlink(public_path() . '/images/layoutads/' . $adv->image1);
                    }
                }

            }
            $adv->delete();
            return back()
                ->with('deleted', 'Advertisement has been deleted !');
        } else {
            return back()
                ->with('warning', '404 Advertisement not found !');
        }

    }

}
