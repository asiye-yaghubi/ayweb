@foreach($subcategories as $subcategory)
        <a href="javascript:void(0)" class="edit-value" style="display:block;" data-id="{{ $subcategory->id }}">
            <option value="{{$subcategory->id}}" >
                <span style="white-space: nowrap;">
                {{$subcategory->title}}
                @if ($subcategory->parents)
                    @include('admin.pages.category.subCategoryTitle',['parent' => $subcategory->parents])
                @endif
            </option> 
        </a>
            
	    @if(count($subcategory->childs))
            @include('admin.pages.category.subCategoryList',['subcategories' => $subcategory->childs])
        @endif
        
@endforeach