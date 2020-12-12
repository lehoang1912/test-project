<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Certificate extends Model implements Transformable
{
    use HasFactory;
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'job_id',
        'certificate_name',
    ];

    /**
     * Get the job that owns the certificate.
     */
    public function job()
    {
        return $this->belongsTo(Job::class);
    }
}
