
@extends('layouts.admin')
@section('title', '編集画面')


@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
              
              
    <form action = {{ action('Admin\GoodsController@update') }} method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    
    
    @if(count($errors) > 0)
    <ul>
     @foreach ($errors->all() as $e)
      <li>{{ $e }}</li>
     @endforeach
     </ul>
    @endif
    
    
    <div class="form-group row">
        <label class="col-md-2">更新</label>
        @if($newform->histories != NULL)
            @foreach( $newform->histories as $history)
                 <div class="show-title">{{ $history->edit_at }}</div>
            @endforeach
        @endif
    </div>
    
    <div class="form-group row">
                        <label class="col-md-2">タイトル</label>
    <div class="col-md-10"><input type="text" name="title" value=" {{ old('title',$newform->title) }}"></div>
    </div>
    
    <div class="form-group row">
                        <label class="col-md-2">画像</label>
                        <img src="{{ asset('storage/image/' . $newform->image_path) }} " class="col-md-10">
     <div class="col-md-10"><input type="file" name="image" value=" {{ old('image',$newform['image_path']) }}"></div>
     <div class="col-md-10">設定中：{{ $newform->image_path}}</div>
     </div>
    
    <div class="form-group row">
                        <label class="col-md-2">プライス</label>
   <div class="col-md-10"> <input type="text" name="price" value=" {{ old('price',$newform->price) }}"></div>
    </div>
    
    <div class="form-group row">
                        <label class="col-md-2">紹介文</label>
    <div class="col-md-10"><textarea name="intro" row="10">{{ old('intro',$newform->intro) }}</textarea></div>
    </div>
  <input type="hidden" name="id" value="{{ $newform->id }}">
  <input type="submit" name="submit" value="登録する" class="btn btn-primary">
  </form>
  
  <div style="margin-bottom:2em"></div>
  <form action = {{ action('Admin\GoodsController@delete') }} method="get" enctype="multipart/form-data">
    {{ csrf_field() }}
    <input type="hidden" value="{{$newform->id}}" name="newsformid">
    <input type ="submit" value="削除する" class="btn btn-primary">
    </form>
</div>
        </div>
    </div>
@endsection
