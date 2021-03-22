<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Goods;
use App\User;
use App\Mail\SendComment;
use App\Comment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;



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
        
        return redirect('admin/goods/');
    }
    
    
    public function index(Request $request){
        $cond_title = $request->cond_title;
        if($cond_title !=''){
            $posts = Goods::where('title','like','%'.$cond_title.'%')->get();
        }else{
            $posts = Goods::all()->sortByDesc('updated_at'); 
        }
        return view('admin/goods/index',['cond_title' => $cond_title, 'posts' => $posts]);
    }
    
    public function show(Request $request){
        $goods = Goods::find($request->id);
        if(empty($goods)){
            abort(404);
        }
        
    
        // $user = Auth::user();
        // $user_name = $user->name;
        
        return view('admin.goods.show',['goods'=>$goods]);
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
        
        return redirect('admin/goods');
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
