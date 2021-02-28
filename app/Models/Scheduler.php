<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scheduler extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'event';

    protected $eventId = 'logId';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'eventName', 'eventStart', 'eventEnd', 'updated_at', 'deleted_at'
    ];
}
