<?php

namespace App\Repositories;

use App\Models\Certificate;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class CertificateRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class CertificateRepositoryEloquent extends BaseRepository implements CertificateRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Certificate::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    // public function boot()
    // {
    //     $this->pushCriteria(app(RequestCriteria::class));
    // }
    
}
