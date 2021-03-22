
@extends('layouts.admin')
@section('title', '一覧')


@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <a href = {{ action('Admin\GoodsController@add') }} role="button" >新規作成</a>
                
                
                
                <form action = {{ action('Admin\GoodsController@index') }} method="get">
                    <input type="text" name="cond_title" value=" {{ $cond_title }}"> 
                    {{ csrf_field() }}
                    <input type="submit" name="" value="検索">
                    </form>
            
              
              
    <div style="margin-bottom:2rem;"></div>
    
    @foreach ($posts as $goods)
    <div style="background-color: #99cc00;">
    <div class="form-group row">
    <label class="col-md-2">タイトル</label>
    <div class="col-md-10">{{ $goods->title }}</div>
    </div>
    
    <div class="form-group row">
    <label class="col-md-2">画像</label>
    <img src="{{ asset('storage/image/' . $goods->image_path) }} " class="col-md-10">
    
     </div>
    
    <div class="form-group row"> 
    <label class="col-md-2">プライス</label>
    <div class="col-md-10"> {{ $goods->price }}</div>
    </div>
    
    <a href="{{ route('goodshow',['id'=>$goods->id]) }} ">詳細を見る</a>
    </div>
    <div style="margin-bottom:2rem;"></div>
    @endforeach
    





</div>
        </div>
    </div>
@endsection