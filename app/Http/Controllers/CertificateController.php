<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateCertificateRequest;
use App\Models\Certificate;
use App\Models\Job;
use App\Repositories\CertificateRepository;
use Illuminate\Http\JsonResponse;

class CertificateController extends Controller
{
    protected CertificateRepository $certificateRepository;

    public function __construct(CertificateRepository $certificateRepository)
    {
        $this->certificateRepository = $certificateRepository;
    }

    /**
     * Add certificate to job
     *
     * @param CreateCertificateRequest $request
     * @param Job $job
     * @return JsonResponse
     */
    public function store(CreateCertificateRequest $request, Job $job): JsonResponse
    {
        $certificate = $this->certificateRepository->create([
            'job_id' => $job->id,
            'certificate_name' => $request->input('certificate_name'),
        ]);
        return response()->json($certificate);
    }

    /**
     * Remove certificate from job
     *
     * @param Job $job
     * @param Certificate $certificate
     * @return JsonResponse
     */
    public function destroy(Job $job, Certificate $certificate): JsonResponse
    {
        $certificate->delete();
        return response()->json(['success' => true]);
    }
}
