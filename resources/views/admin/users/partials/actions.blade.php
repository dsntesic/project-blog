<div class="btn-group">
    <a 
        href="{{route('admin.users.edit',['user' => $user->id])}}" 
        class="btn btn-info"
    >
        <i class="fas fa-edit"></i>
    </a>
    @if($user->isUserBan())
    <button 
        type="button" 
        class="btn btn-info" 
        data-toggle="modal" 
        data-target="#custom-modal"
        data-action='active'
        data-id="{{$user->id}}"
        data-name="{{$user->name}}"
    >
        <i class="fas fa-check"></i>
    </button>
    @endif
    @if($user->isUserActive())
    <button 
        type="button" 
        class="btn btn-info" 
        data-toggle="modal" 
        data-target="#custom-modal"       
        data-action='ban'
        data-id="{{$user->id}}"
        data-name="{{$user->name}}"
    >
        <i class="fas fa-minus-circle"></i>
    </button>
    @endif
</div>

