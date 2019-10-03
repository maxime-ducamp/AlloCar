@if( session()->has('flash') )
    <button class="flash-show flash-{{ session()->get('flash')['status'] }}">
        <p class="text-white text-2xl">
            {{ session()->get('flash')['message'] }}
        </p>
    </button>
@endif










