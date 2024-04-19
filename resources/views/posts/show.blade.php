<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          投稿の個別表示
      </h2>

    @if ($errors->any())
      <div>
        @foreach ($errors->all() as $e )
          <p class="text-red-700">入力エラーがあります</p>
          <li class="text-red-700">{{ $e }}</li>
        @endforeach
      </div>
    @endif
      <x-message :message="session('message')" />

  </x-slot>

  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="mx-4 sm:p-8">
        {{ Breadcrumbs::render('show',$post) }}
          <div class="px-10 mt-4">

              <div class="bg-white w-full  rounded-2xl px-10 py-8 shadow-lg hover:shadow-2xl transition duration-500">
                <div class="mt-4">
                  {{-- アバター表示 --}}
                  <div class="flex">
                    <div class="rounded-full w-12 h-12">
                      @if ($post->user->avatar == 'user_default.jpg')
                        <img src="{{ asset('/avatar/user_default.jpg') }}">
                      @else
                        <img src="{{ $post->user->avatar }}">
                      @endif  
                  </div>
                  
                  <h1 class="text-lg text-gray-700 font-semibold hover:underline cursor-pointer flex-1">
                  <a href="{{route('post.show', $post)}}">{{ $post->title }}</a>
                  </h1>
                </div>
                  <hr class="w-full">
              </div>
              <div class="flex justify-end mt-4">
              @can('update',$post)
                <a href="{{route('post.edit', $post)}}">
                  <x-primary-button class="bg-teal-700 float-right">
                    編集
                  </x-primary-button>
                </a>
              @endcan

              @can('delete',$post)
              <form method="post" action="{{route('post.destroy', $post)}}">
                @csrf
                @method('delete')
                  <x-primary-button class="bg-red-700 float-right ml-4" onClick="return confirm('本当に削除しますか？');">
                    削除
                  </x-primary-button>
            </form>
              @endcan
                  
              </div>
                          
              <div> 
                  <p class="mt-4 text-gray-600 py-4 whitespace-pre-line">{{$post->body}}</p>
                @if ($post->image)
                  <img src="{{ $post->image }}" class="mx-auto" style="height:300px;">
                @endif
                  <div class="text-sm font-semibold flex flex-row-reverse">
                      <p> {{ $post->user->name ?? '削除されたユーザー' }} • {{$post->created_at->diffForHumans()}}</p>
              </div>
                  </div>
                  @foreach ($post->comments as $c )
                    <div class="bg-white w-full  rounded-2xl px-10 py-2 shadow-lg mt-8 whitespace-pre-line">
                      {{ $c->body }}
                      <div class="text-sm font-semibold flex flex-row-reverse">
                        {{--クラスを変更--}}
                        <p class="float-left pt-4">
                          {{ $c->user->name ?? '削除されたユーザー' }}/{{ $c->created_at->diffForHumans() }}
                        </p>
                        {{--アバター追加--}}
                    <span class="rounded-full w-12 h-12">
                  @if ($c->user->avatar == 'user_default.jpg')
                      <img src="{{ asset('/avatar/user_default.jpg') }}">
                  @else
                      <img src="{{ $c->user->avatar }}">
                  @endif
                    </span>
                      </div>
                    </div> 
                  @endforeach
                  {{-- 追加部分 --}}
                  <div class="mt-4 mb-12">
                    <form method="post" action="{{route('comment.store')}}">
                      @csrf
                        <input type="hidden" name='post_id' value="{{$post->id}}">
                        <textarea name="body" class="bg-white w-full  rounded-2xl px-4 mt-4 py-4 shadow-lg hover:shadow-2xl transition duration-500" id="body" cols="30" rows="3" placeholder="コメントを入力してください">{{old('body')}}</textarea>
                        <x-primary-button class="float-right mr-4 mb-12">コメントする</x-primary-button>
                    </form>
                 </div>
                {{-- 追加部分終わり --}}
              </div>
          </div>
      </div>
  </div>
</x-app-layout>