<?php

namespace App\Services\Lookups;
use App\Models\County;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Services\Audit\AuditLogService;
class CountyService
{
    protected AuditLogService $audit;

    public function __construct(AuditLogService $audit)
    {
        $this->audit = $audit;
    }

    /**
     * Store new county
     */
    public function store(array $data): County
    {
        return DB::transaction(function () use ($data) {

            // Generate slug if not provided
            if (empty($data['slug']) && isset($data['name'])) {
                $data['slug'] = Str::slug($data['name']);
            }

            $county = County::create($data);

            // Audit
            $this->audit->log('county_created', $county, [
                'new' => $county->getAttributes(),
            ]);

            return $county;
        });
    }

    /**
     * Update county
     */
    public function update(County $county, array $data): County
    {
        return DB::transaction(function () use ($county, $data) {

            // For auditing old values
            $old = $county->getOriginal();

            // Update slug if name changed
            if (empty($data['slug']) && isset($data['name'])) {
                $data['slug'] = Str::slug($data['name']);
            }

            $county->update($data);

            // Audit
            $this->audit->log('county_updated', $county, [
                'old' => $old,
                'new' => $county->getChanges(),
            ]);

            return $county;
        });
    }

    /**
     * Delete county
     */
    public function destroy(County $county): bool
    {
        return DB::transaction(function () use ($county) {

            $old = $county->getOriginal();

            $deleted = $county->delete();

            // Audit
            $this->audit->log('county_deleted', $county, [
                'old' => $old,
                'new' => null,
            ]);

            return $deleted;
        });
    }
}
