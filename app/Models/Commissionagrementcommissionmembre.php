<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commissionagrementcommissionmembre extends Model
{
	protected $table = 'commissionagrementcommissionmembres';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'commissionagrements_id' => 'int',
		'commissionmembres_id' => 'int'
	];

    public function commissionagrement()
	{
		return $this->belongsTo(Commissionagrement::class);
	}

	public function commissionmembre()
	{
		return $this->belongsTo(Commissionmembre::class);
	}
}
