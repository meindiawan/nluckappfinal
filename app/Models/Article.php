<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
class Article extends Model {
 protected $fillable=['title','slug','subtitle','excerpt','content_json','thumbnail','status','featured','sort_order','published_at'];
 protected $casts=['featured'=>'boolean','published_at'=>'datetime'];

 public function getThumbnailUrlAttribute(): ?string
 {
  if (blank($this->thumbnail)) return null;
  $thumbnail = trim((string) $this->thumbnail);
  // Designs created on localhost may contain absolute localhost URLs.
  // Always make local asset URLs same-origin so LAN clients fetch them from the NLUCK server.
  if (preg_match('~^https?://(?:localhost|127\.0\.0\.1|0\.0\.0\.0)(?::\d+)?(?P<path>/storage/.*)$~i', $thumbnail, $m)) {
      return $m['path'];
  }
  if (str_starts_with($thumbnail, 'http://') || str_starts_with($thumbnail, 'https://')) return $thumbnail;
  $thumbnail = ltrim($thumbnail, '/');
  if (str_starts_with($thumbnail, 'assets/')) return '/' . $thumbnail;
  return '/storage/' . $thumbnail;
 }

 /**
  * Artikel yang tampil di website publik: status terbit DAN jadwal terbit sudah lewat (atau kosong).
  * Dipakai di semua halaman publik supaya daftar & halaman detail selalu konsisten.
  */
 public function scopePublished($query){return $query->where('status','published')->where(fn($q)=>$q->whereNull('published_at')->orWhere('published_at','<=',now()));}

 public function getRouteKeyName(){return 'slug';}
 public function design():array{return $this->content_json?(json_decode($this->content_json,true)?:[]):[];}
 public function leads():HasMany{return $this->hasMany(ArticleLead::class);}
 public function views():HasMany{return $this->hasMany(ArticleView::class);}
 protected static function booted(){static::creating(function($article){if(!$article->slug)$article->slug=Str::slug($article->title);});}
}
