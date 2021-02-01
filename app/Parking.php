<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Parking
 * @package App
 *
 * @property int $gid
 * @property int $id
 * @property float $lat
 * @property float $lng
 * @property string $name
 * @property int $numOfFreePlaces
 * @property int $numOfTakenPlaces
 * @property bool $pr
 * @property int $totalNumOfPlaces
 */
class Parking extends Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'gid',
        'lat',
        'lng',
        'name',
        'numOfFreePlaces',
        'numOfTakenPlaces',
        'pr',
        'totalNumOfPlaces',
    ];
}
