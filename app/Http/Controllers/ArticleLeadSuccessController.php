<?php
namespace App\Http\Controllers;
use App\Models\Article;
use App\Models\ArticleLead;
use App\Models\ArticleFormSetting;
use App\Models\WhatsAppSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
class ArticleLeadSuccessController extends Controller {
 public function show(Request $request,string $slug):View|RedirectResponse{$article=Article::where('slug',$slug)->where('status','published')->where(fn($q)=>$q->whereNull('published_at')->orWhere('published_at','<=',now()))->firstOrFail();$leadId=$request->session()->get('nluck_lead_id');abort_unless($leadId,404);$lead=ArticleLead::whereKey($leadId)->where('article_id',$article->id)->firstOrFail();$setting=WhatsAppSetting::current();$formSetting=ArticleFormSetting::current();return view('articles.lead-success',compact('article','lead','setting','formSetting'));}
}
