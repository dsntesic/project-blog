<div class="btn-group">   
    <a 
        href="" 
        class="btn btn-info"
        target="_blank"              
        title='Show Blog Post'
    >
        <i class="fas fa-eye"></i>
    </a>
    <a 
        href="{{route('admin.blog_posts.edit',['blogPost' => $blogPost->id])}}" 
        class="btn btn-info"       
        title='Edit Blog Post'
        >
        <i class="fas fa-edit"></i>
    </a>
    <button 
        type="button" 
        class="btn btn-info" 
        title='Delete Blog Post'
        data-toggle="modal" 
        data-target="#custom-modal"     
        data-action='delete'  
        data-id="{{$blogPost->id}}"
        data-name="{{$blogPost->name}}"
        >
        <i class="fas fa-trash"></i>
    </button>
</div>
<div class="btn-group">
    @if($blogPost->isBlogPostEnable())
    <button 
        type="button"
        class="btn btn-info" 
        title='Disable Blog Post'
        data-toggle="modal" 
        data-target="#custom-modal"     
        data-action='disable' 
        data-id="{{$blogPost->id}}"
        data-name="{{$blogPost->name}}"
    >
        <i class="fas fa-minus-circle"></i>
    </button>
    @endif
    @if($blogPost->isBlogPostDisable())
    <button 
        type="button" 
        class="btn btn-info" 
        title='Enable Blog Post'
        data-toggle="modal" 
        data-target="#custom-modal"    
        data-action='enable' 
        data-id="{{$blogPost->id}}"
        data-name="{{$blogPost->name}}"
    >
        <i class="fas fa-check"></i>
    </button>
    @endif
    @if($blogPost->isBlogPostImportant())
    <button 
        type="button" 
        class="btn btn-info" 
        title='Set important'
        data-toggle="modal" 
        data-target="#custom-modal"    
        data-action='noImportant' 
        data-id="{{$blogPost->id}}"
        data-name="{{$blogPost->name}}"
    >
        <i class="far fa-star"></i>
    </button>
    @else
    <button 
        type="button" 
        class="btn btn-info" 
        title='Set no important' 
        data-toggle="modal" 
        data-target="#custom-modal"    
        data-action='important' 
        data-id="{{$blogPost->id}}"
        data-name="{{$blogPost->name}}"
    >
        <i class="fas fa-star"></i>
    </button>
    @endif
</div>  

