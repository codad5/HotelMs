<div class="w-400 fixed top-5 space-y-4 right-10 z-50">
    @if(count($errors) > 0)
    @foreach ($errors->all() as $error)
   <div class="px-5 py-3 block bg-red-500 text-center max-w-screen-sm"> {{$error}} </div>
    @endforeach
    @endif
    
    @if(session('success'))
    <div class="px-5 py-3 block bg-green-500 text-center max-w-screen-sm">
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="px-5 py-3 block bg-red-500 text-center max-w-screen-sm">
        {{ session('error') }}
    </div>
    @endif
</div>