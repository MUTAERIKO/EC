<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Goods;
use App\User;
use App\History;
use App\GoodsUser;
use App\Mail\SendComment;
use App\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;




class GoodsController extends Controller
{
    //
    public function add(){
        
        return view ('admin.goods.create');
    }
    
    public function create(Request $request){
        $this -> validate($request,Goods::$rules);
        $goods = new Goods;
        $form = $request->all();
        
        if (isset($form['image'])) {
        $path = $request->file('image')->store('public/image');
        $goods->image_path = basename($path);
      } else {
        $goods->image_path = null;
      }
        $goods->user_id = Auth::id();
        

        unset($form['_token']);
        unset($form['image']);
    
        $goods->fill($form)->save();
        
        return redirect('admin/goods/')->with('message','投稿されました');
    }
    
    
    public function index(Request $request){
        $cond_title = $request->cond_title;
        if($cond_title !=''){
            $posts = Goods::where('title','like','%'.$cond_title.'%')->paginate(6);
            //paginateを追加するとエラーになった。getをpagineteに書き換えると解決
            
        }else{
            $posts = Goods::orderBy('created_at', 'desc')->paginate(6); 
        }
        // $posts = Goods::all()->paginate(15)->sortByDesc('updated_at'); 
        // $posts = DB::table('goods')->paginate(6)->sortByDesc('created_at'); 
        
        // $ninki = $request->ninki;
        // if ($ninki !=''){
        //     $postsninki= Goods::take(3)->get();
        // }else{
            $postsninki = Goods::take(3)->get()->sortByDesc('view_count');
            // $postsninki = Goods::all()->sortByDesc('view_count');
        // }
        return view('admin/goods/index',['cond_title' => $cond_title, 'posts' => $posts,'postsninki' => $postsninki]);
    }
    
    public function show(Request $request){
        $goods = Goods::find($request->id);
        if(empty($goods)){
            abort(404);
        }
        
        // カウント機能
        $view_count = $goods->view_count;
        $goods->view_count = $view_count+1;
        $goods->save();
        
        // dd($view_count);
    
        // $user = Auth::user();
        // $user_name = $user->name;
        
        $history = new History;
        $history->goods_id = $goods->id;
        $history->edit_at = Carbon::now();
        $history->save();
        
        return view('admin.goods.show',['goods'=>$goods,'history'=>$history]);
    }
    
  
        public function goods_user(Goods $goods){
            $goods->users()->attach(Auth::id());
        return back();
    }
    
            public function goods_user_off(Goods $goods){
            $goods->users()->detach(Auth::id());
            return back();
        // return redirect('admin/goods');
    }
    
    
    public function mypage(Request $request){
        
        // お気に入り表示用
        $cond_title = $request->cond_title;
        
        
        if($cond_title !=''){

            $goods = GoodsUser::select()
            ->join('goods','goods.id','=','goods_user.goods_id')
            ->where('title','like','%'.$cond_title.'%')->paginate(2);
            // sqlで書くと下記みたいになるよ
            // select * from goods_user join goods on goods.id = goods_user.goods_id where title like '%%';
            
            
        }else{
            // userが一致したものをUser.phpにリレーションのあるgoodsをよんでくる(中間テーブル使用)
            $goods = GoodsUser::select()
            ->join('goods','goods.id','=','goods_user.goods_id')
            ->paginate(2);
        }
        if(empty($goods)){
            abort(404);
        }
        
        
        // テスト
        // $cond_title = $request->cond_title;
        // if($cond_title !=''){
        //     $goods = Auth::user()->goods::where('title','like','%'.$cond_title.'%')->get();
        // }else{
        //     // userが一致したものをUser.phpにリレーションのあるgoodsをよんでくる(中間テーブル使用)
        //     $goods = Auth::user()->goods;
        // }
        // if(empty($goods)){
        //     abort(404);
        // }
        
        // バックナンバー用
        $user = Auth::user();
        $backnumbers = Goods::where('user_id', $user->id)->get()->sortByDesc('created_at')->take(5);
        // $backnumbers = DB::table('goods')->where ('user_id','=','2')->get()->sortByDesc('updated_at');
        // $backnumbers = Goods::where($request->user_id)->get()->sortByDesc('updated_at');
        
        if(empty($backnumbers)){
            abort(404);
        }

        
        return view('admin.goods.mypage',['goods'=>$goods,'cond_title' => $cond_title,'backnumbers' => $backnumbers]);
    }
    
    
    
    public function comment(Request $request){
        $this->validate($request,Comment::$rules);
        $comment = new Comment;
        $form = $request->all();
        
        unset($form['_token']);
        
        // 作成者のみがコメントを削除できる仕様のため作成（user_idをAuthに紐付ける）
        $comment->user_id=Auth::id();
        $comment->fill($form)->save();
        
        $user = Auth::user();
$goods =  $comment->goods;

$data=[
'subject' =>'コメントが投稿されましたよ',
'comment' =>$comment->comment,
'template' => 'mail.reply',
'name' =>'システムメール',
'email' =>'aaa@aaa.com',
'title' =>$goods->title,
'reply_name'=>$user->name,
];


// dd(Auth::user()->email);


Mail::to($user->email)->send(new SendComment($data));
        
        return redirect('admin/goods/show?id='.$request->goods_id);
    }
    
    public function edit(Request $request){
        $goods = Goods::find($request->id);
        // if(empty($goods)){
        //     abort(404);
        // }
        
        return view('admin.goods.edit',['newform'=>$goods]);
    }
    
    public function update(Request $request){
        $this->validate($request,Goods::$rules);
        $goods = Goods::find($request->id);
        
        $newform = $request->all();

        
        if($request->remove == 'true'){
            $newform['image_path']=null;
        }elseif($request->file('image')){
            $path = $request->file('image')->store('public/image');
            $newform['image_path']= basename($path);
        }else{
            $newform['image_path']= $goods->image_path;
        }
        
        unset($newform['_token']);
        unset($newform['remove']);
        unset($newform['image']);
        $goods->fill($newform)->save();
        
        $history = new History;
        $history->goods_id = $goods->id;
        $history->edit_at = Carbon::now();
        $history->save();
    
        return redirect('admin/goods/');
    }
    
    public function delete(Request $request){
        $goods = Goods::find($request->newsformid);
        $goods->delete();
        
        return redirect('admin/goods');
    }
    
    public function commentdelete(Request $request){
        
        $comment = Comment::find($request->comment_id);
        $comment->delete();
        
        return redirect('admin/goods/show?id='.$request->goods_id);
    }
}
