<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\ArticleFormSettingController;
use App\Http\Controllers\Admin\ArticleWorkflowController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BusinessDashboardController;
use App\Http\Controllers\Admin\LeadController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\PromoBannerController;
use App\Http\Controllers\Admin\SiteContentController;
use App\Http\Controllers\Admin\WhatsAppSettingController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ArticleLeadController;
use App\Http\Controllers\ArticleLeadSuccessController;
use App\Http\Controllers\ArticleWhatsAppController;
use App\Http\Controllers\ProductCatalogController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PublicAssetController;

// Public storage fallback. Static public/storage is used when available;
// this route handles Windows/PHP built-in server cases where the symlink is not served.
Route::get('/storage/{path}', [PublicAssetController::class, 'show'])->where('path', '.*')->name('storage.fallback');

// Public catalog
Route::get('/', [ProductCatalogController::class,'index'])->name('catalog');
Route::get('/katalog', [ProductCatalogController::class,'browse'])->name('catalog.browse');

// Laravel's default auth middleware looks for a route named [login].
// Keep it as a safe entry point that always sends unauthenticated users
// to the NLUCK admin login page.
Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');
Route::get('/produk/{slug}', [ProductCatalogController::class,'show'])->name('products.show');
Route::get('/tentang-kami', [PageController::class, 'show'])->defaults('page', 'tentang-kami')->name('pages.about');
Route::get('/filosofi', [PageController::class, 'show'])->defaults('page', 'filosofi')->name('pages.philosophy');
Route::get('/doa', [PageController::class, 'show'])->defaults('page', 'doa')->name('pages.doa');
Route::get('/artikel', [ArticleController::class,'index'])->name('articles.index');
Route::post('/artikel/{slug}/daftar', [ArticleLeadController::class,'store'])->name('articles.leads.store');
Route::get('/artikel/{slug}/berhasil', [ArticleLeadSuccessController::class,'show'])->name('articles.leads.success');
Route::get('/artikel/{slug}/whatsapp/{lead}/klik', [ArticleWhatsAppController::class,'click'])->name('articles.whatsapp.click');
Route::get('/artikel/{slug}', [ArticleController::class,'show'])->name('articles.show');

Route::prefix('admin')->name('admin.')->group(function(){
 Route::get('/login',[AuthController::class,'create'])->name('login');
 Route::post('/login',[AuthController::class,'store'])->name('login.store');
 Route::middleware('auth')->group(function(){
  Route::get('/',[BusinessDashboardController::class,'index'])->name('dashboard');
  Route::get('/dashboard',[BusinessDashboardController::class,'index'])->name('dashboard.business');
  Route::post('/logout',[AuthController::class,'destroy'])->name('logout');
  Route::get('/account',[AccountController::class,'edit'])->name('account.edit');
  Route::put('/account',[AccountController::class,'update'])->name('account.update');
  Route::resource('products',ProductController::class)->except(['show']);
  Route::resource('promo-banners',PromoBannerController::class)->except(['show']);
  Route::resource('articles',AdminArticleController::class)->except(['show']);
  Route::get('/articles/{article}/studio',[AdminArticleController::class,'studio'])->name('articles.studio');
  Route::get('/articles/{article}/studio/data',[AdminArticleController::class,'studioData'])->name('articles.studio.data');
  Route::post('/articles/{article}/studio/save',[AdminArticleController::class,'studioSave'])->name('articles.studio.save');
  Route::get('/articles/{article}/preview',[AdminArticleController::class,'preview'])->name('articles.preview');
  Route::get('/articles/{article}/qr',[AdminArticleController::class,'qr'])->name('articles.qr');
  Route::get('/articles/{article}/qr/download',[AdminArticleController::class,'qrDownload'])->name('articles.qr.download');
  Route::post('/articles/{article}/publish',[ArticleWorkflowController::class,'publish'])->name('articles.publish');
  Route::post('/articles/{article}/unpublish',[AdminArticleController::class,'unpublish'])->name('articles.unpublish');
  Route::post('/articles/{article}/duplicate',[ArticleWorkflowController::class,'duplicate'])->name('articles.duplicate');
  Route::get('/media/json',[MediaController::class,'libraryJson'])->name('media.json');
  Route::get('/media',[MediaController::class,'index'])->name('media.index');
  Route::post('/media',[MediaController::class,'store'])->name('media.store');
  Route::patch('/media/{media}',[MediaController::class,'update'])->name('media.update');
  Route::delete('/media/{media}',[MediaController::class,'destroy'])->name('media.destroy');
  Route::get('/leads',[LeadController::class,'index'])->name('leads.index');
  Route::get('/leads/export',[LeadController::class,'export'])->name('leads.export');
  Route::get('/leads/{lead}',[LeadController::class,'show'])->name('leads.show');
  Route::patch('/leads/{lead}/status',[LeadController::class,'status'])->name('leads.status');
  Route::delete('/leads/{lead}',[LeadController::class,'destroy'])->name('leads.destroy');
  Route::get('/analytics',[AnalyticsController::class,'index'])->name('analytics');
  Route::get('/whatsapp',[WhatsAppSettingController::class,'edit'])->name('whatsapp.edit');
  Route::put('/whatsapp',[WhatsAppSettingController::class,'update'])->name('whatsapp.update');
  Route::get('/form-artikel',[ArticleFormSettingController::class,'edit'])->name('form-settings.edit');
  Route::put('/form-artikel',[ArticleFormSettingController::class,'update'])->name('form-settings.update');
  Route::get('/konten/{key}',[SiteContentController::class,'edit'])->name('site-content.edit');
  Route::put('/konten/{key}',[SiteContentController::class,'update'])->name('site-content.update');
 });
});
