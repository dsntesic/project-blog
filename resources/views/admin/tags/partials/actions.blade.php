<div class="btn-group">   
    <a href="" class="btn btn-info" target="_blank">
        <i class="fas fa-eye"></i>
    </a>
    <a 
        href="{{route('admin.tags.edit',['tag' => $tag->id])}}" 
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
        data-id="{{$tag->id}}"
        data-name="{{$tag->name}}"
        >
        <i class="fas fa-trash"></i>
    </button>
</div>

