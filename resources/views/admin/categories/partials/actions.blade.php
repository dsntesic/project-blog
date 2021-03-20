<div class="btn-group">   
    <a href="{{$category->getSingleCategory()}}" class="btn btn-info" target="_blank">
        <i class="fas fa-eye"></i>
    </a>
    <a 
        href="{{route('admin.categories.edit',['category' => $category->id])}}" 
        class="btn btn-info"
        >
        <i class="fas fa-edit"></i>
    </a>
    <button 
        type="button" 
        class="btn btn-info" 
        data-toggle="modal" 
        data-target="#custom-modal"       
        data-action='delete'
        data-id="{{$category->id}}"
        data-name="{{$category->name}}"
        >
        <i class="fas fa-trash"></i>
    </button>
</div>

