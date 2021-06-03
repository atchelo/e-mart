@foreach($menus->where('status','=','1')->orderBy('position','ASC')->get() as $menu)
	
		@if($menu->link_by == 'url')
		<li>
			<a href="{{ $menu->url }}">@if($menu->icon != NULL || $menu->icon != '') <i class="fa {{ $menu->icon }}"></i>&nbsp;@endif{{ $menu->title }}
			</a>
		</li>
			   
		@endif

		@if($menu->link_by == 'page')
		<li>
			<a href="{{ route('page.slug',$menu->gotopage->slug) }}">@if($menu->icon != NULL || $menu->icon != '') <i class="fa {{ $menu->icon }}"></i>&nbsp;@endif{{ $menu->title }}
			</a>

		</li>
		@endif

		@if($menu->link_by == 'cat')
			@if($menu->show_cat_in_dropdown != 1)
			<li>
				@php
					$category_id = $menu->cat_id;
				@endphp
				<a href="@if($menu->show_child_in_dropdown == 1 && $menu->linked_parent != NULL) {{ App\Helpers\CategoryUrl::getURL($category_id) }} @else {{ App\Helpers\CategoryUrl::getURL($category_id) }} @endif">@if($menu->icon != NULL || $menu->icon != '') <i class="fa {{ $menu->icon }}"></i>&nbsp;@endif{{ $menu->title }}
		
				</a>  
			
			</li>

			@endif
			   
		@endif

		
	
@endforeach