<?php
  
namespace App;
   
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
   
class Book extends Model implements HasMedia
{
	use SoftDeletes, InteractsWithMedia;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'author_id',
        'title',
        'subject',
        'description',
        'serial_number',
        'version_date'
    ];
  public function author(){
    return $this->belongsTo(Author::class);
  }
    public static function fields() {
        return [
            'books.id',
            'author_id',
            'name',
        	'title',
            'subject',
            'description',
            'serial_number',
            'version_date',
        	'books.created_at',
        	'books.updated_at'
        ];
    }

    public static function aliases() {
        return array(
            'id'         => 'books.id',
            'created_at' => 'books.created_at',
            'updated_at' => 'books.updated_at'
        );
    }
}