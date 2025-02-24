<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Feuillepresencecollective extends Model
{
    use HasFactory;
	use SoftDeletes;
	use \App\Helpers\UuidForKey;

	protected $table = 'feuillepresencecollectives';
    
    protected $casts = [
		'listecollectives_id' 	=> 'int',
		'emargementcollectives_id' 	=> 'int'
	];

    protected $fillable = [
		'uuid',
		'emargementcollectives_id',
		'listecollectives_id',
		'presence',
		'signature'
	];

	public function individuelle()
	{
		return $this->belongsTo(Listecollective::class, 'listecollectives_id');
	}

	public function emargementCollective()
    {
        return $this->belongsTo(Emargementcollective::class, 'emargementcollectives_id');
    }
}
