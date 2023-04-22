<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rent extends Model
{
    use HasFactory;

    /**
     * Obtém raça de pet
     *
     * @return void
    */
    public function ads(){
        return $this->hasMany(Rent::class);
    }

    public function scopeSearchByUser($query, $userId) {

        $query->from("rents as r")
        ->join("ads as a", "a.id", "r.ad_id")
        ->join("users as uh", "uh.id", "r.hirer_id")
        ->join("users as ur", "ur.id", "r.renter_id")
        ->select("uh.name as hirer_name", "ur.name as renter_name", "a.name as vehicle_name", "r.*");

        $query->where("hirer_id", $userId)->orwhere("hirer_id", $userId);

    }

}
