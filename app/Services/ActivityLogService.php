<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class ActivityLogService
{
    /**
     * Record an administrative activity log.
     */
    public function log(
        string $action,
        ?string $targetType = null,
        ?int $targetId = null,
        mixed $oldValue = null,
        mixed $newValue = null
    ): void {
        $oldString = $this->formatValue($oldValue);
        $newString = $this->formatValue($newValue);

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'target_type' => $targetType,
            'target_id' => $targetId,
            'old_value' => $oldString,
            'new_value' => $newString,
            'ip_address' => request()->ip(),
        ]);
    }

    /**
     * Format values to string/JSON for logging.
     */
    private function formatValue(mixed $value): ?string
    {
        if ($value === null) {
            return null;
        }

        if (is_array($value) || is_object($value)) {
            return json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }

        return (string) $value;
    }
}
