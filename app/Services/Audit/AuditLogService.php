<?php

namespace App\Services\Audit;
use App\Models\AuditLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
class AuditLogService
{
    public function log(string $action, $auditable = null, array $meta = []): AuditLog
    {
        return AuditLog::create([
            'auditable_type' => $auditable ? get_class($auditable) : null,
            'auditable_id'   => $auditable?->id,
            'user_id'        => Auth::id(),
            'action'         => $action,
            'old_values'     => $meta['old'] ?? null,
            'new_values'     => $meta['new'] ?? null,
            'ip_address'     => Request::ip(),
            'user_agent'     => Request::userAgent(),
            'url'            => Request::fullUrl(),
        ]);
    }

    public function logModelChange(string $action, $model): AuditLog
    {
        return $this->log($action, $model, [
            'old' => $model->getOriginal(),
            'new' => $model->getChanges(),
        ]);
    }
}
