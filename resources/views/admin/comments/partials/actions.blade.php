<div class="btn-group">   
    <a 
        href="{{$comment->blogPost->getSingleBlogPost()}}" 
        class="btn btn-info"
        target="_blank"              
        title='Show Blog Post'
    >
        <i class="fas fa-eye"></i>
    </a>
    @if($comment->isCommentEnable())
    <button 
        type="button"
        class="btn btn-info" 
        title='Disable Blog Post'
        data-toggle="modal" 
        data-target="#custom-modal"     
        data-action='disable' 
        data-id="{{$comment->id}}"
        data-name="{{$comment->name}}"
    >
        <i class="fas fa-minus-circle"></i>
    </button>
    @endif
    @if($comment->isCommentDisable())
    <button 
        type="button" 
        class="btn btn-info" 
        title='Enable Blog Post'
        data-toggle="modal" 
        data-target="#custom-modal"    
        data-action='enable' 
        data-id="{{$comment->id}}"
        data-name="{{$comment->name}}"
    >
        <i class="fas fa-check"></i>
    </button>
    @endif
</div>  

