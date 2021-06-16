
@extends('layouts.admin')
@section('title', 'マイページ')


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
  <form action = {{ action('Admin\GoodsController@mypage') }} method="get">
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
          
          <ul>
            <div class="topickatamari">
              
              
              @foreach ($goods as $one_goods)
                <li><a href="{{ route('goodshow',['id'=>$one_goods->id]) }} "><img src="{{ asset('storage/image/' . $one_goods->image_path) }}" height="150px" ></a><br>
                  <a href="{{ route('goodshow',['id'=>$one_goods->id]) }} "><p>{{ $one_goods->title }}</p></a>
                </li>
              @endforeach
              
            </div>
            <div class="page">{{ $goods->links() }}</div>
          </ul>
        </div>


      </div> 
    

      <div class="right-side-mypage">
        <div class="minikiji">
          <div class="rank"><i class="fas fa-book"></i>　バックナンバー</div>
          <hr color="#192738">
          
          
          @foreach($backnumbers as $goods)
          
          <div class="minitext">
            <a href="{{ route('goodshow',['id'=>$goods->id]) }} "><p><B> {{ $goods->updated_at }}</B> .{{ $goods->title }}</p></a>
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
     
              
    <div style="margin-bottom:2rem;"></div>


</div>
    





</div>
        </div>
    </div>
@endsection