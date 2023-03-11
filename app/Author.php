<?php
  
namespace App;
   
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
   
class Author extends Model
{
	use SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'address',
        'phone',
        'birthday'
    ];
    public function books(){
        return $this->hasMany(Book::class);
      }
    public static function fields() {
        return [
            'id',
        	'name',
            'address',
            'phone',
            'birthday',
        	'created_at',
        	'updated_at'
        ];
    }
}