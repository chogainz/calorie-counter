     @yield('flash')
     @if (session()->has('flash_message'))
	    <div class="flash-message alert alert-{{session('flash_message_level') }}">
	    	{{session('flash_message')}} 
	    </div>
    @endif