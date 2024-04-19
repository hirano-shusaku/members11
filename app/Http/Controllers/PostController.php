<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Storage;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::orderBy('created_at','desc')->get();
        $user = auth()->user();
        return view('posts.index',compact('posts','user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        if($request->hasFile('image'))
        {
            $image = $request->file('image');
        //$requestからimageファイルを取得
            $path = Storage::disk('s3')->putFile('post',$image,'public');
        //s3に画像をUPロード
            $url = Storage::disk('s3')->url($path);
        //DBにURLを取得
            Post::create([
                'title' => $request['title'],
                'body' => $request['body'],
                'user_id' => auth()->user()->id,
                'image' => $url
            ]);
        }
        else
        {
            Post::create([
                'title' => $request['title'],
                'body' => $request['body'],
                'user_id' => auth()->user()->id,
            ]);
        }
        
        return redirect()->route('post.index')->with('message','投稿を作成しました');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('posts.show',compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request,Post $post)
    {
        if($request->user()->cannot('update',$post))
        {
            abort(403);
        }

        return view('posts.edit',compact('post'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, Post $post)
    {
        if($request->user()->cannot('update',$post))
        {
            abort(403);
        }
        // dd($post);
        $old = $post->image;
        if($request->hasFile('image'))
        {
            $image = $request->file('image');
        //$requestからimageファイルを取得
            if($post->image){
                $oldPath = parse_url($old, PHP_URL_PATH);
                // dd($old,$oldPath);
                Storage::disk('s3')->delete($oldPath);
            //もし既に画像があった場合、既存の画像を削除
            }  
            $path = Storage::disk('s3')->putFile('post',$image,'public');
        //s3に画像をUPロード
            $url = Storage::disk('s3')->url($path);
        //DBにURLを取得
        // dd($url,$post);
            $post->image = $url;
        }
        
        $post->title = $request['title'];
        $post->body = $request['body'];
        $post->user_id = auth()->user()->id;
        $post->save();

        return redirect()->route('post.show',$post)->with('message','投稿を更新しました');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,Post $post)
    {
        if($request->user()->cannot('delete',$post))
        {
            abort(403);
        }
        
        $post->comments()->delete();
        $post->delete();
        return redirect()->route('post.index')->with('message','投稿を削除しました');
    }

    public function mypost()
    {
        $user = auth()->user()->id;
        $posts = Post::where('user_id',$user)->orderBy('created_at','desc')->get();

        return view('posts.mypost',compact('posts'));
    }

    public function mycomment()
    {
        $user = auth()->user()->id;
        $comments = Comment::where('user_id', $user)->orderBy('created_at','desc')->get();

        return view('posts.mycomment',compact('comments'));
    }
}
