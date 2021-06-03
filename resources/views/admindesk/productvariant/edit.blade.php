@extends("admindesk/layouts.master")
@section('title','Edit Product Variant | ')
@section("body")



<div class="box">

    <div class="box-header with-border">
        <div class="box-title">
            Edit Product Variant For <b>{{ $vars->products->name }}</b>
        </div>
    </div>



    <div class="box-body">

        @php
        $pro = App\Product::where('id',$vars->pro_id)->first();
        $row = App\AddSubVariant::withTrashed()->where('pro_id',$vars->pro_id)->get();
        @endphp

        <div>
            <form action="{{ route('updt.var',$vars->id) }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}

                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab"
                            data-toggle="tab">Edit Variant</a></li>
                    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Edit
                            Pricing & Weight</a></li>
                    <li role="presentation"><a href="#messages" aria-controls="messages" role="tab"
                            data-toggle="tab">Manage Stock</a></li>

                    <li role="presentation"><a href="#stockimg" aria-controls="messages" role="tab"
                            data-toggle="tab">Edit Images</a></li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="home">@foreach($pro->variants as $key => $var)
                        <br>


                        <div class="panel panel-default">

                            <div class="panel-heading">
                                <input child_id="{{$key+3}}" class="hasCheck" type="checkbox" name="main_attr_id[]"
                                    id="{{$key+3}}" value="{{ $var->attr_name }}">


                                @php
                                $k = '_';
                                @endphp
                                @if (strpos($var->getattrname->attr_name, $k) == false)

                                {{ $var->getattrname->attr_name }}

                                @else

                                {{str_replace('_', ' ', $var->getattrname->attr_name)}}

                                @endif
                            </div>


                            <div class="panel-body">

                                @foreach($var->attr_value as $a => $value)
                                @php
                                $nameofvalue = App\ProductValues::where('id','=',$value)->first();
                                @endphp
                                <label>

                                    <?php
                                    try
                                        {
                                            $x = $vars->main_attr_value[$var->attr_name];
                                            if($x == $value)
                                            {
                                                ?>



                                    <input class="a" onload="test('{{ $var->attr_name }}')" checked="checked"
                                        value="{{ $value }}" type="radio" name="main_attr_value[{{$var->attr_name}}]"
                                        id="ch{{$key+3}}">

                                    <script type="text/javascript">
                                        var newId = {{ $key }} + 3;
                                        $('#' + newId).prop('checked', true);
                                    </script>

                                    @if(strcasecmp($nameofvalue->unit_value, $nameofvalue->values) !=0)

                                    @if($var->getattrname->attr_name == "Color" || $var->getattrname->attr_name ==
                                    "Colour")

                                    <div class="margin-left-minus-15 inline-flex">
                                        <div class="color-options">
                                            <ul>
                                                <li title="{{ $nameofvalue->values }}" class="color varcolor active"><a
                                                        href="#" title=""><i
                                                            style="color: {{ $nameofvalue->unit_value }}"
                                                            class="fa fa-circle"></i></a>
                                                    <div class="overlay-image overlay-deactive">
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <span class="tx-color">{{ $nameofvalue->values }}</span>


                                    @else
                                    {{ $nameofvalue->values }}{{ $nameofvalue->unit_value }}
                                    @endif
                                    @else
                                    {{ $nameofvalue->values }}
                                    @endif



                                </label>
                                <?php
                                                
                                            }
                                            else
                                            {
                                                ?>


                                <input class="b" value="{{ $value }}" type="radio"
                                    name="main_attr_value[{{$var->attr_name}}]" id="ch2{{ $key+3 }}{{$a}}">

                                @if(strcasecmp($nameofvalue->unit_value, $nameofvalue->values) !=0)

                                @if($var->getattrname->attr_name == "Color" || $var->getattrname->attr_name == "Colour")
                                <div class="margin-left-minus-15 inline-flex">
                                    <div class="color-options">
                                        <ul>
                                            <li title="{{ $nameofvalue->values }}" class="color varcolor active"><a
                                                    href="#" title=""><i style="color: {{ $nameofvalue->unit_value }}"
                                                        class="fa fa-circle"></i></a>
                                                <div class="overlay-image overlay-deactive">
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <span class="tx-color">{{ $nameofvalue->values }}</span>
                                @else
                                {{ $nameofvalue->values }}{{ $nameofvalue->unit_value }}
                                @endif
                                @else
                                {{ $nameofvalue->values }}
                                @endif
                                <?php
                                            }
                                            
                                        }
                                        catch(exception $e) {
                                            ?>

                                <input class="c" value="{{ $value }}" type="radio"
                                    name="main_attr_value[{{$var->attr_name}}]" id="ch3{{ $key+3 }}{{$a}}">

                                {{$nameofvalue->values}}{{ $nameofvalue->unit_value }}



                                </label>
                                <?php

                                        }

                                    
                                ?>

                                @endforeach



                            </div>



                        </div>



                        @endforeach

                        <div class="col-md-12 form-group">

                            <label>Set Default: <input {{ $vars->def ==1 ? "checked" : "" }} type="checkbox"
                                    name="def"></label>
                        </div>

                    </div>
                    <div role="tabpanel" class="tab-pane" id="profile">
                        <br>
                        <div class="col-md-6">

                            <div class="form-group">
                                <label for="">Edit Additional Price For This Variant:</label>

                                <div class="row">

                                    <div class="col-md-6">
                                        <input required placeholder="Enter Price ex 499.99" value="{{ $vars->price }}"
                                            type="number" step=0.01 class="form-control" name="price">

                                    </div>
                                </div>


                                <small class="help-block">Please enter Price In Positive or Negative or zero<br>


                                </small>

                                <p class="help-border">
                                    <b>Ex. </b>If you enter +10 and product price is 100 than price will be 110
                                    <br> OR <br>
                                    If you enter -10 and product price is 100 than price will be 90
                                </p>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="weight">Weight:</label>
                                        <input type="number" step=0.01 name="weight" class="form-control"
                                            value="{{ $vars->weight }}" placeholder="0.00">
                                    </div>
                                    <div class="margin-top-25 col-md-6">
                                        <select name="w_unit" class="select2 form-control">
                                            <option value="">Please Choose</option>
                                            @php
                                                $unit = App\Unit::find(1);
                                            @endphp
                                            @if(isset($unit))
                                            @foreach($unit->unitvalues as $unitVal)
                                            <option {{ $vars->w_unit == $unitVal->id ? "selected"  :"" }}
                                                value="{{ $unitVal->id }}">{{ ucfirst($unitVal->short_code) }}
                                                ({{ $unitVal->unit_values }})</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="messages">
                        <br>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Edit Stock: <small><b>[ Current Stock: {{ $vars->stock }}</b>
                                        ]</small></label>
                                <input data-placement="bottom" id="stock" data-toggle="popover" data-trigger="focus"
                                    data-title="Need help?"
                                    data-content="It will add stock in existing stock. For example you enter 10 and existing stock is 20 than total stock will be 30."
                                    type="text" value="" name="stock" class="form-control">

                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Edit Min Order Qty:</label>
                                <input type="text" value="{{ $vars->min_order_qty }}" name="min_order_qty"
                                    class="form-control">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Edit Max Order Qty:</label>
                                <input type="text" value="{{ $vars->max_order_qty }}" name="max_order_qty"
                                    class="form-control">
                            </div>
                        </div>

                    </div>
                    <div role="tabpanel" class="tab-pane" id="stockimg">

                        <br>
                        <div class="row">

                            {{-- example --}}

                            <div class="col-md-2">
                                <div class="bg-var-box-custom panel panel-primary bg-primary">

                                    <label class="pad-15">Image 1</label>




                                    <div align="center" class="padding-0 panel-body">


                                        @if($vars->variantimages && $vars->variantimages['image1'])
                                        <img class="test1 margin-bottom-10" id="preview1" align="center" width="150"
                                            height="150"
                                            src="{{ url('variantimages/'.$vars->variantimages['image1']) }}" alt="">
                                        @else
                                        <img class="margin-bottom-10 margin-top-minus-15" id="preview1" align="center"
                                            width="150" height="150" src="{{ url('images/imagechoosebg.png') }}" alt="">
                                        @endif


                                    </div>

                                    <div class="heyx file-upload">
                                        <div class="file-select">
                                            <div class="file-select-button" id="fileName">Choose File</div>
                                            <div class="file-select-name" id="noFile">No file chosen...</div>
                                            <input name="image1" type="file" name="chooseFile" id="image1">
                                        </div>
                                    </div>
                                    <br>
                                    @if($vars->variantimages && $vars->variantimages['image1'] != null)

                                    <div class="row">



                                        <div class="col-md-12">

                                            <button cusid="{{ $vars->variantimages['id'] }}" id="btn-single"
                                                value="{{ $vars->variantimages['image1'] }}" title="Delete this?"
                                                class="btn btn-sm btn-block btn-danger btn-ema {{ $vars->variantimages['image1'] != $vars->variantimages['main_image'] ? '' : 'display-none' }}"
                                                type="button">
                                                <i class="fa fa-trash-o"></i>
                                            </button>


                                        </div>



                                        <div class="col-md-12">

                                            <button disabled="disabled" id="btn-dis1"
                                                title="You cannot delete Default Image"
                                                class="btn btn-sm btn-block btn-danger btn-ema {{ $vars->variantimages['image1'] == $vars->variantimages['main_image'] ? "" : 'display-none' }}"
                                                type="button">
                                                <i class="fa fa-trash-o"></i>
                                            </button>


                                        </div>


                                    </div>



                                    @endif


                                </div>

                            </div>


                            <div class="col-md-2">
                                <div class="bg-var-box-custom panel panel-primary bg-primary">

                                    <label class="pad-15">Image 2</label>




                                    <div class="padding-0" align="center" class="panel-body">


                                        @if($vars->variantimages && $vars->variantimages['image2'])
                                        <img class="margin-bottom-10 test2" id="preview2" align="center" width="150"
                                            height="150"
                                            src="{{ url('variantimages/'.$vars->variantimages['image2']) }}" alt="">
                                        @else
                                        <img class="margin-top-minus-15 margin-bottom-10" id="preview2" align="center"
                                            width="150" height="150" src="{{ url('images/imagechoosebg.png') }}" alt="">
                                        @endif


                                    </div>

                                    <div class="heyx file-upload2">
                                        <div class="file-select2">
                                            <div class="file-select-button2" id="fileName2">Choose File</div>
                                            <div class="file-select-name2" id="noFile2">No file chosen...</div>
                                            <input name="image2" type="file" name="chooseFile" id="image2">
                                        </div>
                                    </div>
                                    <br>
                                    @if($vars->variantimages && $vars->variantimages['image2'] != null)


                                    <div class="row">

                                        <div class="col-md-12">
                                            <button cusid="{{ $vars->variantimages['id'] }}" id="btn-single2"
                                                value="{{ $vars->variantimages['image2'] }}" title="Delete this?"
                                                class="btn btn-sm btn-block btn-danger btn-ema {{ $vars->variantimages['image2'] != $vars->variantimages['main_image'] ? '' : 'display-none' }}"
                                                type="button">
                                                <i class="fa fa-trash-o"></i>
                                            </button>
                                        </div>

                                        <div class="col-md-12">
                                            <button id="btn-dis2" disabled="disabled"
                                                title="You cannot delete Default Image"
                                                class="btn btn-sm btn-block btn-danger {{ $vars->variantimages['image2'] == $vars->variantimages['main_image'] ? '' : 'display-none' }}"
                                                type="button">
                                                <i class="fa fa-trash-o"></i>
                                            </button>
                                        </div>

                                    </div>

                                    @endif




                                </div>

                            </div>

                            <div class="col-md-2">
                                <div class="bg-var-box-custom panel panel-primary bg-primary">

                                    <label class="pad-15">Image 3</label>




                                    <div align="center" class="padding-0 panel-body">


                                        @if($vars->variantimages && $vars->variantimages['image3'])
                                        <img class="test3 btm-10 " id="preview3" align="center" width="150" height="150"
                                            src="{{ url('variantimages/'.$vars->variantimages['image3']) }}" alt="">
                                        @else
                                        <img id="preview3" align="center" width="150" height="150"
                                            src="{{ url('images/imagechoosebg.png') }}" alt=""
                                            class="btm-10 margin-top-5">
                                        @endif


                                    </div>

                                    <div class="file-upload3 heyx">
                                        <div class="file-select3">
                                            <div class="file-select-button3" id="fileName3">Choose File</div>
                                            <div class="file-select-name3" id="noFile3">No file chosen...</div>
                                            <input name="image3" type="file" name="chooseFile" id="image3">
                                        </div>
                                    </div>
                                    <br>
                                    @if($vars->variantimages && $vars->variantimages['image3'] != null)



                                    <div class="row">

                                        <div class="col-md-12">
                                            <button cusid="{{ $vars->variantimages['id'] }}" id="btn-single3"
                                                value="{{ $vars->variantimages['image3'] }}" title="Delete this?"
                                                class="btn btn-sm btn-block btn-danger btn-ema {{ $vars->variantimages['image3'] != $vars->variantimages['main_image'] ? '' : 'display-none' }}"
                                                type="button">
                                                <i class="fa fa-trash-o"></i>
                                            </button>
                                        </div>

                                        <div class="col-md-12">
                                            <button id="btn-dis3" disabled="disabled"
                                                title="You cannot delete Default Image !"
                                                class="btn btn-sm btn-block btn-danger {{ $vars->variantimages['image3'] == $vars->variantimages['main_image'] ? '' : 'display-none' }}"
                                                type="button">
                                                <i class="fa fa-trash-o"></i>
                                            </button>

                                        </div>
                                    </div>





                                    @endif


                                </div>

                            </div>

                            <div class="col-md-2">
                                <div class="bg-var-box-custom panel panel-primary bg-primary">

                                    <label class="pad-15">Image 4</label>




                                    <div align="center" class="panel-body padding-0">


                                        @if($vars->variantimages && $vars->variantimages['image4'])
                                        <img class="test4 margin-bottom-10" id="preview4" align="center" width="150"
                                            height="150"
                                            src="{{ url('variantimages/'.$vars->variantimages['image4']) }}" alt="">
                                        @else
                                        <img id="preview4" align="center" width="150" height="150"
                                            src="{{ url('images/imagechoosebg.png') }}" alt=""
                                            class="margin-bottom-10 margin-top-5">
                                        @endif


                                    </div>

                                    <div class="file-upload4 heyx">
                                        <div class="file-select4">
                                            <div class="file-select-button4" id="fileName4">Choose File</div>
                                            <div class="file-select-name4" id="noFile4">No file chosen...</div>
                                            <input name="image4" type="file" name="chooseFile" id="image4">
                                        </div>
                                    </div>
                                    <br>
                                    @if($vars->variantimages && $vars->variantimages['image4'] != null)



                                    <div class="row">

                                        <div class="col-md-12">
                                            <button cusid="{{ $vars->variantimages['id'] }}" id="btn-single4"
                                                value="{{ $vars->variantimages['image4'] }}" title="Delete this?"
                                                class="btn btn-sm btn-block btn-danger btn-ema {{ $vars->variantimages['image4'] != $vars->variantimages['main_image'] ? '' : 'display-none' }}"
                                                type="button">
                                                <i class="fa fa-trash-o"></i>
                                            </button>
                                        </div>

                                        <div class="col-md-12">
                                            <button id="btn-dis4" disabled="disabled"
                                                title="You cannot delete Default Image !"
                                                class="btn btn-sm btn-block btn-danger {{ $vars->variantimages['image4'] == $vars->variantimages['main_image'] ? "" : 'display-none' }}"
                                                type="button">
                                                <i class="fa fa-trash-o"></i>
                                            </button>
                                        </div>

                                    </div>





                                    @endif


                                </div>

                            </div>

                            <div class="col-md-2">
                                <div class="bg-var-box-custom panel panel-primary bg-primary">

                                    <label class="pad-15">Image 5</label>




                                    <div align="center" class="panel-body padding-0">


                                        @if($vars->variantimages && $vars->variantimages['image5'])
                                        <img class="test5 margin-bottom-10" id="preview5" align="center" width="150"
                                            height="150"
                                            src="{{ url('variantimages/'.$vars->variantimages['image5']) }}" alt="">
                                        @else
                                        <img id="preview5" align="center" width="150" height="150"
                                            src="{{ url('images/imagechoosebg.png') }}" alt=""
                                            class="margin-bottom-10 margin-top-5">
                                        @endif


                                    </div>

                                    <div class="file-upload5 heyx">
                                        <div class="file-select5">
                                            <div class="file-select-button5" id="fileName5">Choose File</div>
                                            <div class="file-select-name5" id="noFile5">No file chosen...</div>
                                            <input name="image5" type="file" name="chooseFile" id="image5">
                                        </div>
                                    </div>
                                    <br>
                                    @if($vars->variantimages && $vars->variantimages['image5'] != null)



                                    <div class="row">

                                        <div class="col-md-12">
                                            <button cusid="{{ $vars->variantimages['id'] }}" id="btn-single5"
                                                value="{{ $vars->variantimages['image5'] }}" title="Delete this?"
                                                class="btn btn-sm btn-block btn-danger btn-ema {{ $vars->variantimages['image5'] != $vars->variantimages['main_image'] ? '' : 'display-none' }}"
                                                type="button">
                                                <i class="fa fa-trash-o"></i>
                                            </button>
                                        </div>

                                        <div class="col-md-12">
                                            <button id="btn-dis5" disabled="disabled"
                                                title="You cannot delete Default Image !"
                                                class="btn btn-sm btn-block btn-danger {{ $vars->variantimages['image5'] == $vars->variantimages['main_image'] ? '' : 'display-none' }}"
                                                type="button">
                                                <i class="fa fa-trash-o"></i>
                                            </button>
                                        </div>
                                    </div>





                                    @endif


                                </div>

                            </div>

                            <div class="col-md-2">
                                <div class="bg-var-box-custom panel panel-primary bg-primary">

                                    <label class="pad-15">Image 6</label>




                                    <div align="center" class="panel-body padding-0">


                                        @if($vars->variantimages && $vars->variantimages['image6'])
                                        <img class="test6 margin-bottom-10" id="preview6" align="center" width="150"
                                            height="150"
                                            src="{{ url('variantimages/'.$vars->variantimages['image6']) }}" alt="">
                                        @else
                                        <img id="preview6" align="center" width="150" height="150"
                                            src="{{ url('images/imagechoosebg.png') }}" alt=""
                                            class="margin-bottom-10 margin-top-5">
                                        @endif


                                    </div>

                                    <div class="file-upload6 heyx">
                                        <div class="file-select6">
                                            <div class="file-select-button6" id="fileName6">Choose File</div>
                                            <div class="file-select-name6" id="noFile6">No file chosen...</div>
                                            <input name="image6" type="file" name="chooseFile" id="image6">
                                        </div>
                                    </div>
                                    <br>
                                    @if($vars->variantimages && $vars->variantimages['image6'] != null)

                                    @if($vars->variantimages['image6'] != $vars->variantimages['image2'])

                                    <div class="row">

                                        <div class="col-md-12">
                                            <button cusid="{{ $vars->variantimages['id'] }}" id="btn-single6"
                                                value="{{ $vars->variantimages['image6'] }}" title="Delete this?"
                                                class="btn btn-sm btn-block btn-danger btn-ema {{ $vars->variantimages['image6'] != $vars->variantimages['main_image'] ? '' : 'display-none' }}"
                                                type="button">
                                                <i class="fa fa-trash-o"></i>
                                            </button>
                                        </div>

                                        <div class="col-md-12">
                                            <button id="btn-dis6" disabled="disabled"
                                                title="You cannot delete Default Image !"
                                                class="btn btn-sm btn-block btn-danger {{ $vars->variantimages['image6'] == $vars->variantimages['main_image'] ? '' : 'display-none' }}"
                                                type="button">
                                                <i class="fa fa-trash-o"></i>
                                            </button>
                                        </div>
                                    </div>



                                    @endif

                                    @endif


                                </div>

                            </div>

                            <div class="col-md-12">
                                <hr>
                                <div class="row">
                                    <div class="col-md-4">
                                        <label>Select Default Image: </label>
                                        <select name="defimage" id="defimage" class="form-control">

                                            @if($vars->variantimages && $vars->variantimages['image1'] != null)
                                            <option
                                                {{ $vars->variantimages['image1'] == $vars->variantimages['main_image'] ? "selected" : ""}}
                                                value="{{ $vars->variantimages['image1'] }}">Image 1</option>
                                            @endif

                                            @if($vars->variantimages && $vars->variantimages['image2'] != null)
                                            <option
                                                {{ $vars->variantimages['image2'] == $vars->variantimages['main_image'] ? "selected" : ""}}
                                                value="{{ $vars->variantimages['image2'] }}">Image 2</option>
                                            @endif

                                            @if($vars->variantimages && $vars->variantimages['image3'] != null)
                                            <option
                                                {{ $vars->variantimages['image3'] == $vars->variantimages['main_image'] ? "selected" : ""}}
                                                value="{{ $vars->variantimages['image3'] }}">Image 3</option>
                                            @endif

                                            @if($vars->variantimages && $vars->variantimages['image4'] != null)
                                            <option
                                                {{ $vars->variantimages['image4'] == $vars->variantimages['main_image'] ? "selected" : ""}}
                                                value="{{ $vars->variantimages['image4'] }}">Image 4</option>
                                            @endif

                                            @if($vars->variantimages && $vars->variantimages['image5'] != null)
                                            <option
                                                {{ $vars->variantimages['image5'] == $vars->variantimages['main_image'] ? "selected" : ""}}
                                                value="{{ $vars->variantimages['image5'] }}">Image 5</option>
                                            @endif

                                            @if($vars->variantimages && $vars->variantimages['image6'] != null)
                                            <option
                                                {{ $vars->variantimages['image6'] == $vars->variantimages['main_image'] ? "selected" : ""}}
                                                value="{{ $vars->variantimages['image6'] }}">Image 6</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>



                            </div>


                        </div>


                    </div>

                </div>
                <br><br>
                <div class="col-md-12 form-group">
                    <button @if(env('DEMO_LOCK')==0) type="submit" onclick="formty()" @else disabled=""
                        title="This action is disabled in demo !" @endif class="btn btn-md btn-primary">
                        <i class="fa fa-save"></i> Update
                    </button>

                    <a href="{{ route('add.var',$vars->products->id) }}"><button type="button"
                            class="btn btn-md btn-default">
                            <i class="fa fa-chevron-circle-left" aria-hidden="true"></i> Back
                        </button>
                    </a>
                </div>

            </form>
        </div>


    </div>
</div>


@endsection

@section('custom-script')
<script>
    var baseUrl = "<?= url('/') ?>";
</script>
<script src="{{ url('js/variant.js') }}"></script>
<script>
    var url = @json(url('/setdef/var/image/'.$vars->id));
</script>
<script src="{{url('js/variantimage.js')}}"></script>
@endsection