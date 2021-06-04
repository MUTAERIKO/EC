
@extends('layouts.admin')
@section('title', '一覧')


@section('content')

    <!--<div class="container">-->
    <!--    <div class="row">-->
    <!--        <div class="col-md-8 mx-auto">-->
    <!--            <a href = {{ action('Admin\GoodsController@add') }} role="button" >新規作成</a>-->
                
                
                
    <!--            <form action = {{ action('Admin\GoodsController@index') }} method="get">-->
    <!--                <input type="text" name="cond_title" value=" {{ $cond_title }}"> -->
    <!--                {{ csrf_field() }}-->
    <!--                <input type="submit" name="" value="検索">-->
    <!--                </form>-->
            
     <!--ちょっとここに入れてみるか-->
     
     <div class="kensaku">
  <form action = {{ action('Admin\GoodsController@index') }} method="get">
                    <input type="text" class="kensaku-box" name="cond_title" value=" {{ $cond_title }}"> 
                    {{ csrf_field() }}
                    <input type="submit" name="" class="kensaku-soushin" value="Search">
                    </form>
</div>
     

     
     
         <div class="SP">
      <input type="checkbox" id="open">
      <label for="open" class="line">あ</label>
      <label for="open" class="back"></label>

      <div class="humber">
        テキスト<br>
        ちょっとした<br>
        てきすと<br>
      </div>
    </div>


    <!-- <div class="main">
      <img class="anime_test" src="nikko.png">
    </div> -->

    <div class="under">
      <div class="left-side">
        <div class="topic">
          <!-- <p>topic</p> -->
          
          @if(session('message'))
            {{ session('message') }}
          @endif
          
          <ul>
            <div class="topickatamari">
                @foreach ($posts as $goods)
              <li><a href="{{ route('goodshow',['id'=>$goods->id]) }} "><img src="{{ asset('storage/image/' . $goods->image_path) }}" height="150px" ></a><br>
                <a href="{{ route('goodshow',['id'=>$goods->id]) }} "><p>{{ $goods->title }}</p></a>
              </li>
              @endforeach
             
            </div>
           
          </ul>
          {{ $posts->links() }}
           
        </div>


      </div> 
    

      <div class="right-side">
        <div class="minikiji">
          <div class="rank"><i class="fas fa-crown"></i>　ランキング</div>
          <hr color="#192738">
          @foreach($postsninki as $goods)
          <div class="minitext">
            <a href="{{ route('goodshow',['id'=>$goods->id]) }} "><p><B> {{ $loop->index+1 }}</B> .{{ $goods->title }}</p></a>
          </div>
          <div class="miniimage">
            <a href="{{ route('goodshow',['id'=>$goods->id]) }} "><img src="{{ asset('storage/image/' . $goods->image_path) }} "></a>
          </div>
        <div class="betumono"><hr color="#192738" style="2px"></div>
        @endforeach
        </div>

        


       
        


      </div>
    </div>

    <footer class="marushi">©risutoahiru</footer>
    <!--ここまでに入れてみた-->
     
              
    <!--<div style="margin-bottom:2rem;"></div>-->
    
    <!--@foreach ($posts as $goods)-->
    <!--<div style="background-color: #99cc00;">-->
    <!--<div class="form-group row">-->
    <!--<label class="col-md-2">タイトル</label>-->
    <!--<div class="col-md-10">{{ $goods->title }}</div>-->
    <!--</div>-->
    
    <!--<div class="form-group row">-->
    <!--<label class="col-md-2">画像</label>-->
    <!--<img src="{{ asset('storage/image/' . $goods->image_path) }} " class="col-md-10">-->
    
    <!-- </div>-->
    
    <!--<div class="form-group row"> -->
    <!--<label class="col-md-2">プライス</label>-->
    <!--<div class="col-md-10"> {{ $goods->price }}</div>-->
    <!--</div>-->
    
    <!--<a href="{{ route('goodshow',['id'=>$goods->id]) }} ">詳細を見る</a>-->
    <!--</div>-->
    <!--<div style="margin-bottom:2rem;"></div>-->
    <!--@endforeach-->
    
    
<!-- サイドバーにするつもり -->
    <div style="background-color: #333;">
    @foreach($postsninki as $goods)
<div class="form-group row">
        
    <div class="col-md-10"> {{ $loop->index+1 }}</div>
    <label class="col-md-2">タイトル</label>
    <div class="col-md-10"> {{ $goods->price }}</div>
    
</div>
    @endforeach
</div>
    





</div>
        </div>
    </div>
@endsection