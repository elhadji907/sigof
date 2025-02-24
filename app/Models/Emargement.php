<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Emargement extends Model
{
    use HasFactory;
	use SoftDeletes;
	use \App\Helpers\UuidForKey;
	protected $table = 'emargements';

    protected $casts = [
		'individuelles_id' 	=> 'int',
        'date' 				=> 'datetime'
	];

    protected $dates = [
        'date'
    ];

	protected $fillable = [
		'uuid',
		'formations_id',
		'jour',
		'date',
		'observations',
		'file',
		'individuelles_id'
	];

	public function getFileEmargement(){
		$filePath = $this->file ?? '';
		return "/storage/" . $filePath;
	}

	public function individuelle()
	{
		return $this->belongsTo(Individuelle::class, 'individuelles_id');
	}

	
	public function feuillesPresences()
    {
        return $this->hasMany(Feuillepresence::class, 'emargements_id');
    }

	public function formation()
	{
		return $this->belongsTo(Formation::class, 'formations_id');
	}

}
