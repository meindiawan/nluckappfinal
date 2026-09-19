<?php
namespace App\Http\Controllers;
use App\Models\Article;
use App\Models\ArticleFormSetting;
use App\Models\ArticleView;
use Illuminate\Http\Request;
class ArticleController extends Controller {
 public function index(Request $request){$q=trim($request->string('q')->toString());$articles=Article::query()->where('status','published')->where(fn($x)=>$x->whereNull('published_at')->orWhere('published_at','<=',now()))->when($q,fn($x)=>$x->where(fn($w)=>$w->where('title','like',"%$q%")->orWhere('subtitle','like',"%$q%")->orWhere('excerpt','like',"%$q%")))->orderByDesc('featured')->orderBy('sort_order')->orderByDesc('published_at')->paginate(9)->withQueryString();return view('articles.index',compact('articles','q'));}
 public function show(Request $request,string $slug){$article=Article::where('slug',$slug)->where('status','published')->where(fn($q)=>$q->whereNull('published_at')->orWhere('published_at','<=',now()))->firstOrFail();$sessionKey=$request->session()->getId();$exists=ArticleView::where('article_id',$article->id)->where('session_key',$sessionKey)->whereDate('created_at',today())->exists();if(!$exists){ArticleView::create(['article_id'=>$article->id,'session_key'=>$sessionKey,'ip_hash'=>$request->ip()?hash('sha256',$request->ip()):null,'user_agent'=>substr((string)$request->userAgent(),0,1000),'referer'=>substr((string)$request->headers->get('referer'),0,1000)]);}$related=Article::where('status','published')->where('id','!=',$article->id)->orderByDesc('featured')->orderBy('sort_order')->latest('published_at')->limit(3)->get();$design=$article->design();$formSetting=ArticleFormSetting::current();return view('articles.studio-render',compact('article','related','design','formSetting'));}
}
