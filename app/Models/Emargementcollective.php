<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Emargementcollective extends Model
{
    use HasFactory;
	use SoftDeletes;
	use \App\Helpers\UuidForKey;
	protected $table = 'emargementcollectives';
    
    protected $casts = [
		'listecollectives_id' 	=> 'int',
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
		'listecollectives_id'
	];

	public function getFileEmargement(){
		$filePath = $this->file ?? '';
		return "/storage/" . $filePath;
	}

	public function listecollective()
	{
		return $this->belongsTo(Listecollective::class, 'listecollectives_id');
	}
	
	public function feuillesPresenceCollectives()
    {
        return $this->hasMany(Feuillepresencecollective::class, 'emargementcollectives_id');
    }

	public function formation()
	{
		return $this->belongsTo(Formation::class, 'formations_id');
	}
}
