<?php

namespace App\Services\Lookups;
use App\Models\PostalCode;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Services\Audit\AuditLogService;
class PostalCodeService
{
    protected AuditLogService $audit;

    public function __construct(AuditLogService $audit)
    {
        $this->audit = $audit;
    }

    public function store(array $data): PostalCode
    {
        return DB::transaction(function () use ($data) {

            if (empty($data['slug'])) {
                $data['slug'] = Str::slug($data['code'] . '-' . $data['town']);
            }

            $pc = PostalCode::create($data);

            $this->audit->log('postal_code_created', $pc, [
                'new' => $pc->getAttributes()
            ]);

            return $pc;
        });
    }

    public function update(PostalCode $pc, array $data): PostalCode
    {
        return DB::transaction(function () use ($pc, $data) {

            $old = $pc->getOriginal();

            if (empty($data['slug'])) {
                $data['slug'] = Str::slug($data['code'] . '-' . $data['town']);
            }

            $pc->update($data);

            $this->audit->log('postal_code_updated', $pc, [
                'old' => $old,
                'new' => $pc->getChanges()
            ]);

            return $pc;
        });
    }

    public function destroy(PostalCode $pc): bool
    {
        return DB::transaction(function () use ($pc) {

            $old = $pc->getOriginal();

            $deleted = $pc->delete();

            $this->audit->log('postal_code_deleted', $pc, [
                'old' => $old,
                'new' => null
            ]);

            return $deleted;
        });
    }
}
