<x-guest-layout>
    <body class="bg-gray-200 font-sans leading-normal tracking-normal">
               
                <!--Title-->
                <div class="mb-2 ml-64">
                    <p class="text-black font-extrabold text-3xl md:text-4xl">
                        laravel 11 new 画像掲示板
                    </p>
                </div>
                    <p class="text-xl md:text-2xl text-gray-600 mb-4 ml-64">ようこそ 画像掲示版へ</p>
            </div>
            <!--1/2 col -->
            <div class="h-screen pb-14 bg-right bg-cover">
                <div class="container pt-4 md:pt-8 px-6 mx-auto flex flex-wrap flex-col md:flex-row items-center bg-yellow-50">
                    
            <div class="flex flex-wrap justify-between">
					<div class="w-full md:w-1/2 p-6 flex flex-col flex-grow flex-shrink">
						<div class="flex-1 bg-white rounded-t rounded-b-none overflow-hidden shadow-lg">
							<a href="#" class="flex flex-wrap no-underline hover:no-underline">
								<img src="{{ asset('logo/replsent.jpg') }}" class="h-full w-full rounded-t pb-6" style="max-height:600px;">
								<p class="w-full text-gray-600 text-xs md:text-sm px-6">laravel 11での画像掲示板となります</p>
								<div class="w-full font-bold text-xl text-gray-900 px-6">登録をしてお好きな画像をアップロードしてください</div>
								<p class="text-gray-800 font-serif text-base px-6 mb-5">
									もちろん画像だけではなく、掲示板みたいに文字での投稿も同時に行えます！ 
								</p>
							</a>
						</div>
						<div class="flex-none mt-auto bg-white rounded-b rounded-t-none overflow-hidden shadow-lg p-6">
							{{-- ボタン設定 --}}
                            <a href="{{ route('register') }}">
                                <button class="btnsetr"> ご登録 </button>
                            </a>
                            <a href="{{ route('login') }}">
                                <button class="btnsetb">ログイン</button>
                            </a>
                            
						</div>
					</div>

					<!--1/2 col -->
					<div class="w-full md:w-1/2 p-6 flex flex-col flex-grow flex-shrink">
						<div class="flex-1 flex-row bg-white rounded-t rounded-b-none overflow-hidden shadow-lg">
							<a href="#" class="flex flex-wrap no-underline hover:no-underline">	
								<img src="{{ asset('logo/doragon.jpg') }}" class="h-full w-full rounded-t pb-6" style="max-height:600px;">
								<p class="w-full text-gray-600 text-xs md:text-sm px-6">1つ1つの投稿がとても魅力的ですよ
                                </p>
								<div class="w-full font-bold text-xl text-gray-900 px-6">投稿1つ1つにコメントも入力できますよ！</div>
								<p class="text-gray-800 font-serif text-base px-6 mb-5">
									お気軽に投稿やコメントをpost見てみてください！ 
								</p>
							</a>
						</div>
						<div class="flex-none mt-auto bg-white rounded-b rounded-t-none overflow-hidden shadow-lg p-6">
							<div class="flex items-center justify-between">
								
                                    {{-- ボタン設定 --}}
                                    <a href="{{ route('contact.create') }}">
                                        <button class="btnsetg">お問い合わせ</button>
                                    </a>
                                </div>
							</div>
						</div>
					</div>
            </div>
                </div>
            
            


        
    </x-guest-layout>