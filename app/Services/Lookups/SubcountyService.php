<?php

namespace App\Services\Lookups;

use App\Models\Subcounty;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Services\Audit\AuditLogService;
class SubcountyService
{
    protected AuditLogService $audit;

    public function __construct(AuditLogService $audit)
    {
        $this->audit = $audit;
    }

    public function store(array $data): Subcounty
    {
        return DB::transaction(function () use ($data) {

            if (empty($data['slug'])) {
                $data['slug'] = Str::slug($data['name']);
            }

            $subcounty = Subcounty::create($data);

            $this->audit->log('subcounty_created', $subcounty, [
                'new' => $subcounty->getAttributes()
            ]);

            return $subcounty;
        });
    }

    public function update(Subcounty $subcounty, array $data): Subcounty
    {
        return DB::transaction(function () use ($subcounty, $data) {

            $old = $subcounty->getOriginal();

            if (empty($data['slug'])) {
                $data['slug'] = Str::slug($data['name']);
            }

            $subcounty->update($data);

            $this->audit->log('subcounty_updated', $subcounty, [
                'old' => $old,
                'new' => $subcounty->getChanges()
            ]);

            return $subcounty;
        });
    }

    public function destroy(Subcounty $subcounty): bool
    {
        return DB::transaction(function () use ($subcounty) {

            $old = $subcounty->getOriginal();

            $deleted = $subcounty->delete();

            $this->audit->log('subcounty_deleted', $subcounty, [
                'old' => $old,
            ]);

            return $deleted;
        });
    }
}
