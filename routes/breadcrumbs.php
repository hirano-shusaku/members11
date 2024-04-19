<?php // routes/breadcrumbs.php

// Note: Laravel will automatically resolve `Breadcrumbs::` without
// this import. This is nice for IDE syntax and refactoring.
use Diglactic\Breadcrumbs\Breadcrumbs;

// This import is also not required, and you could replace `BreadcrumbTrail $trail`
//  with `$trail`. This is nice for IDE type checking and completion.
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Home
Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push('Home', route('post.index'));
});

// Home > 新規post
Breadcrumbs::for('create', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('新規投稿', route('post.create'));
});

Breadcrumbs::for('show', function (BreadcrumbTrail $trail,$post) {
  //dd($recipe);
  $trail->parent('home');
  $trail->push("詳細画面", route('post.show',$post->id));
});

//詳細→編集
Breadcrumbs::for('edit', function (BreadcrumbTrail $trail,$post) {
  $trail->parent('show',$post);
  $trail->push("編集画面", route('post.edit',$post->id));
});

// home→自分のみ投稿
Breadcrumbs::for('mypost', function (BreadcrumbTrail $trail) {
  $trail->parent('home');
  $trail->push("自分の投稿", route('post.mypost'));
});

// home→自分のみ投稿
Breadcrumbs::for('mycomment', function (BreadcrumbTrail $trail) {
  $trail->parent('mypost');
  $trail->push("自分のコメントした投稿", route('post.mycomment'));
});

