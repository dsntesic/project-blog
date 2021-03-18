<div class="btn-group">
    <a 
        href="{{route('admin.sliders.edit',['slider' => $slider->id])}}" 
        class="btn btn-info"
        >
        <i class="fas fa-edit"></i>
    </a>
    @if($slider->isSliderEnable())
    <button 
        type="button"
        class="btn btn-info" 
        title='Disable Blog Post'
        data-toggle="modal" 
        data-target="#custom-modal"     
        data-action='disable' 
        data-id="{{$slider->id}}"
        data-name="{{$slider->name}}"
    >
        <i class="fas fa-minus-circle"></i>
    </button>
    @endif
    @if($slider->isSliderDisable())
    <button 
        type="button" 
        class="btn btn-info" 
        title='Enable Blog Post'
        data-toggle="modal" 
        data-target="#custom-modal"    
        data-action='enable' 
        data-id="{{$slider->id}}"
        data-name="{{$slider->name}}"
    >
        <i class="fas fa-check"></i>
    </button>
    @endif
    <button 
        type="button" 
        class="btn btn-info" 
        data-toggle="modal" 
        data-target="#custom-modal"       
        data-action='delete'
        data-id="{{$slider->id}}"
        data-name="{{$slider->name}}"
        >
        <i class="fas fa-trash"></i>
    </button>
</div>

