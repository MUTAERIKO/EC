
@extends('layouts.admin')
@section('title', '記事の新規作成')


@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
              
              
    <form action = {{ action('Admin\GoodsController@create') }} method="post" enctype="multipart/form-data">
    {{ csrf_field() }}
    
    
    @if(count($errors) > 0)
    <ul>
     @foreach ($errors->all() as $e)
      <li>{{ $e }}</li>
     @endforeach
     </ul>
    @endif
    
    <div class="form-group row">
                        <label class="col-md-2">タイトル</label>
    <div class="col-md-10"><input type="text" name="title" value=" {{ old('title') }}"></div>
    </div>
    
    <div class="form-group row">
                        <label class="col-md-2">日付</label>
    <div class="col-md-10"><input type="date" name="date" value=" {{ old('date') }}"></div>
    </div>
    
    <div class="form-group row">
                        <label class="col-md-2">画像</label>
     <div class="col-md-10"><input type="file" name="image" value=" {{ old('image_path') }}"></div>
     </div>
    
    <div class="form-group row">
                        <label class="col-md-2">プライス</label>
   <div class="col-md-10"> <input type="text" name="price" value=" {{ old('price') }}"></div>
    </div>
    
    <div class="form-group row">
                        <label class="col-md-2">紹介文</label>
    <div class="col-md-10"><textarea name="intro" row="10">{{ old('intro') }}</textarea></div>
    </div>
  
  <input type="submit" name="submit" value="登録する" class="btn btn-primary">
  </form>
</div>
        </div>
    </div>
@endsection