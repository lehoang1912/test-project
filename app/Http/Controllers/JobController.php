<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateJobRequest;
use App\Http\Requests\UpdateJobRequest;
use App\Models\Job;
use App\Repositories\JobRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class JobController extends Controller
{
    protected JobRepository $jobRepository;

    public function __construct(JobRepository $jobRepository)
    {
        $this->jobRepository = $jobRepository;
    }

    /**
     * Get jobs
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $data = $this->jobRepository
            ->with(['user:id,first_name,last_name'])
            ->orderBy('id', 'desc')
            ->paginate($request->input('limit'));
        return response()->json($data);
    }

    /**
     * Get a job
     *
     * @param Job $job
     * @return JsonResponse
     */
    public function show(Job $job): JsonResponse
    {
        $job->load(['user:id,first_name,last_name', 'certificates:id,job_id,certificate_name']);
        return response()->json($job);
    }

    /**
     * Add a new job
     *
     * @param CreateJobRequest $request
     * @return JsonResponse
     */
    public function store(CreateJobRequest $request): JsonResponse
    {
        $job = $this->jobRepository->create([
            'user_id' => $request->user()->id,
            'job_name' => $request->input('job_name'),
            'job_date' => $request->input('job_date'),
        ]);

        return response()->json($job);
    }

    public function update(UpdateJobRequest $request, Job $job):JsonResponse
    {
        return response()->json(tap($job)->update([
            'job_name' => $request->input('job_name'),
            'job_date' => $request->input('job_date'),
        ]));
    }

    /**
     * Delete job
     *
     * @param Job $job
     * @return JsonResponse
     */
    public function destroy(Job $job): JsonResponse
    {
        $job->delete();
        return response()->json(['success' => true]);
    }
}
