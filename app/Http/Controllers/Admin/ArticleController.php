<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
class ArticleController extends Controller {
 public function index(Request $request){$q=trim($request->string('q')->toString());$articles=Article::query()->when($q,fn($x)=>$x->where(fn($w)=>$w->where('title','like',"%$q%")->orWhere('slug','like',"%$q%")->orWhere('excerpt','like',"%$q%")))->when($request->filled('status'),fn($x)=>$x->where('status',$request->input('status')))->when($request->filled('featured'),fn($x)=>$x->where('featured',$request->boolean('featured')))->orderByDesc('featured')->orderBy('sort_order')->latest()->paginate(12)->withQueryString();return view('admin.articles.index',compact('articles','q'));}
 public function create(){return view('admin.articles.create');}
 public function store(Request $request){$data=$this->validated($request);$data['slug']=$this->uniqueSlug($data['slug']??$data['title']);$data['featured']=$request->boolean('featured');$article=Article::create($data);$this->saveCover($request,$article);return redirect()->route('admin.articles.studio',$article)->with('success','Artikel dibuat. Lanjutkan desain di Studio.');}
 public function edit(Article $article){return view('admin.articles.edit',compact('article'));}
 public function update(Request $request,Article $article){$data=$this->validated($request,$article->id);$data['slug']=$this->uniqueSlug($data['slug']??$data['title'],$article->id);$data['featured']=$request->boolean('featured');$article->update($data);$this->saveCover($request,$article);return redirect()->route('admin.articles.index')->with('success','Artikel berhasil diperbarui.');}
 public function destroy(Article $article){$article->delete();return back()->with('success','Artikel dihapus.');}
 public function studio(Article $article){return view('admin.articles.studio',compact('article'));}
 public function studioData(Article $article){return response()->json(['id'=>$article->id,'status'=>$article->status,'published_at'=>optional($article->published_at)->toIso8601String(),'updated_at'=>optional($article->updated_at)->toIso8601String(),'design'=>$article->design()]);}
 public function studioSave(Request $request,Article $article){$payload=$request->validate(['design'=>'required|array','action'=>'nullable|in:draft,publish']);$design=$payload['design'];$content=$design['content']??[];$plain=fn($v)=>trim(strip_tags((string)$v));$title=$plain($content['hero_title']??'')?:$plain($content['collection_name']??'')?:$article->title;$subtitle=$plain($content['collection_badge_text']??$content['hero_subtitle']??'');$excerpt=$plain($content['hero_paragraph']??$content['philosophy_paragraph_1']??'');$hero=collect($design['assets']??[])->firstWhere('target','hero_banner_photo');$action=$payload['action']??'draft';$update=['title'=>Str::limit($title,180,''),'subtitle'=>Str::limit($subtitle,255,''),'excerpt'=>Str::limit($excerpt,1000,''),'content_json'=>json_encode($design,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES)];if($action==='publish'){$update['status']='published';$update['published_at']=$article->published_at?:now();}$article->update($update);$article->refresh();return response()->json(['ok'=>true,'message'=>$action==='publish'?'Artikel berhasil diterbitkan.':'Draft tersimpan.','article'=>$article->only(['id','title','slug','status','thumbnail','published_at','updated_at'])]);}

 public function qr(Article $article){
  $target=route('articles.show',$article);
  $qrImage='https://api.qrserver.com/v1/create-qr-code/?size=700x700&margin=16&data='.urlencode($target);
  return view('admin.articles.qr',compact('article','target','qrImage'));
 }
 public function qrDownload(Article $article){
  $target=route('articles.show',$article);
  $url='https://api.qrserver.com/v1/create-qr-code/?size=1200x1200&margin=24&format=png&data='.urlencode($target);
  try {
   $response=Http::timeout(20)->get($url);
   abort_unless($response->successful(),502,'QR tidak dapat dibuat saat ini.');
   return response($response->body(),200,['Content-Type'=>'image/png','Content-Disposition'=>'attachment; filename="qr-'.$article->slug.'.png"','Cache-Control'=>'no-store']);
  } catch (\Throwable $e) {
   return redirect()->route('admin.articles.qr',$article)->with('error','QR belum dapat diunduh. Pastikan komputer terhubung internet.');
  }
 }
 public function preview(Article $article){$design=$article->design();$formSetting=\App\Models\ArticleFormSetting::current();return view('admin.articles.preview',compact('article','design','formSetting'));}
 public function unpublish(Article $article){$article->update(['status'=>'draft']);return back()->with('success','Artikel dikembalikan menjadi draft.');}
 private function validated(Request $request,$id=null){return $request->validate(['title'=>['required','string','max:180'],'slug'=>['nullable','string','max:190'],'subtitle'=>['nullable','string','max:255'],'excerpt'=>['nullable','string','max:1000'],'status'=>['required','in:draft,published'],'featured'=>['nullable','boolean'],'sort_order'=>['nullable','integer','min:0'],'published_at'=>['nullable','date'],'thumbnail'=>['nullable','image','mimes:jpg,jpeg,png,webp,gif','max:5120']]);}
 private function saveCover(Request $request, Article $article): void
 {
  if(!$request->hasFile('thumbnail')) return;
  $old=$article->thumbnail;
  $path=$request->file('thumbnail')->store('article-covers','public');
  $article->update(['thumbnail'=>$path]);
  if($old && !str_starts_with($old,'assets/')) { try { Storage::disk('public')->delete(ltrim($old,'/')); } catch(\Throwable $e) {} }
 }
 private function uniqueSlug($value,$ignore=null){$base=Str::slug($value)?:Str::random(8);$slug=$base;$i=1;while(Article::where('slug',$slug)->when($ignore,fn($q)=>$q->where('id','!=',$ignore))->exists())$slug=$base.'-'.$i++;return $slug;}
}
