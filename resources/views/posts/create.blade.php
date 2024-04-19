<x-app-layout>
  <x-slot name="script">
    <script src="/js/posts/create.js"></script>
  </x-slot>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      投稿の新規作成
    </h2>
    {{-- @if (session('message'))
      {{ session('message') }}
    @endif --}}
    <x-validation class="mb-4" :errors="$errors" />
    {{-- <x-input-error class="mb-4" :messages="$errors->all()"/> --}}
    <x-message :message="session('message')" />
  </x-slot>
  
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="mx-4 sm:p-8">
      {{ Breadcrumbs::render('create') }}
        <form method="post" action="{{ route('post.store') }}" enctype="multipart/form-data">
          @csrf
            <div class="md:flex items-center mt-8">
                <div class="w-full flex flex-col">
                <label for="title" class="font-semibold leading-none mt-4">件名</label>
                <input type="text" name="title" value="{{ old('title') }}" class="w-auto py-2 placeholder-gray-300 border border-gray-300 rounded-md" id="title" placeholder="Enter Title">
                </div>  
            </div>
          @if ($errors->has('title'))
            <p class="text-red-400">{{ $errors->first('title') }}</p>
          @endif
            
            <div class="w-full flex flex-col">
                <label for="body" class="font-semibold leading-none mt-4">本文</label>
                <textarea name="body" class="w-auto py-2 border border-gray-300 rounded-md" id="body" cols="30" rows="10">{{ old('body') }}</textarea>
            </div>
          @if ($errors->has('body'))
            <p class="text-red-400">{{ $errors->first('body') }}</p>
          @endif
            

            <div class="w-full flex flex-col">
                <img id="preview" class="object-cover w-1/4 aspect-video pt-6" src="{{ asset('images/aaaa.png') }}" alt="post-image" style="max-height:200px;">
                <label for="image" class="font-semibold leading-none mt-4">画像 (※1Mまで)</label>
                <div>
                <input id="image" type="file" name="image">
                </div>
            </div>
          
            <x-primary-button class="mt-4">
                送信する
            </x-primary-button>
            
        </form>
    </div>
</div>

</x-app-layout>