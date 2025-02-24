<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Feuillepresence extends Model
{
    use HasFactory;
	use SoftDeletes;
	use \App\Helpers\UuidForKey;

	protected $table = 'feuillepresences';
    
    protected $casts = [
		'individuelles_id' 	=> 'int',
		'emargements_id' 	=> 'int'
	];

    protected $fillable = [
		'uuid',
		'emargements_id',
		'individuelles_id',
		'presence',
		'signature'
	];

	public function individuelle()
	{
		return $this->belongsTo(Individuelle::class, 'individuelles_id');
	}
	

	public function emargement()
    {
        return $this->belongsTo(Emargement::class, 'emargements_id');
    }
}
