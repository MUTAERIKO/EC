
@extends('layouts.admin')
@section('title', '詳細ページ')


@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
              
    
    <div class="form-group row">
    
    @if($goods->users()->where('user_id', Auth::id())->exists())               
    <form action= {{ route('goods_user_off', $goods)  }} method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="col-md-10">
        <input type="hidden" value="{{ $goods->id }}" name="goods_id">
        
        <input type="submit" value=" &#xf004; お気に入りを取り消す" class="fas buttonokini">
     </div>
    </form>
    @else
    <!--取り消すボタン-->
    <form action= {{ route('goods_user', $goods)  }} method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    <div class="col-md-10">
        <input type="hidden" value="{{ $goods->id }}" name="goods_id">
        
        <input type="submit" value=" &#xf004; お気に入りにする" class="fas buttonokini"></div>
    </form>
    @endif
    </div>
    
    
    
    <div class="form-group row">
                        <!--<label class="col-md-2">タイトル</label>-->
    <div class="show-title">{{ $goods->title }}</div>
    </div>
    
    <div class="form-group row showimage">
                        <!--<label class="col-md-2">画像</label>-->
     <img src="{{ asset('storage/image/' . $goods->image_path) }} " class="showimage">
     </div>
    
    <div class="form-group row">
                        <label class="col-md-2">プライス</label>
   <div class="col-md-10"> <input type="text" name="price" value=" {{ $goods->price }}"></div>
    </div>
    
    <div class="form-group row">
                        <label class="col-md-2">紹介文</label>
    <div class="col-md-10"><textarea name="intro" row="10">{{ $goods->intro }}</textarea></div>
    </div>
  

@if($goods->user_id === Auth::id())
<a href= "{{ route('goodsedit',['id'=>$goods->id]) }}">編集</a>
@endif


<div style="background-color:#fff">
<form action= {{ action('Admin\GoodsController@comment') }} method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    
    <textarea name="comment" row="30" cols="80"> {{ old('comment') }}</textarea>
    
    <input type="hidden" value="{{ $goods->id }}" name="goods_id">
    <input type="submit" value="投稿する">
    </form>
</div>
    
    
@if ($goods->comments !=null)
@foreach( $goods->comments as $comment)
<ul>
    <li>{{ $comment->comment }} </li>
    
    @if($comment->user_id === Auth::id())
    <form action = {{ action('Admin\GoodsController@commentdelete') }} method="get" enctype="multipart/form-data">
    {{ csrf_field() }}
    <input type ="hidden" value="{{$comment->id}}" name="comment_id">
    <input type ="hidden" value="{{$goods->id}}" name="goods_id">
    <input type ="submit" value="削除する">
    </form>
    @endif
</ul>
@endforeach
@endif 




    

</div>
        </div>
    </div>
@endsection