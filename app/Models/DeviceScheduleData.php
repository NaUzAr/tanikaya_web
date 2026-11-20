<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeviceScheduleData extends Model
{
    protected $table = 'device_schedule_data';

    protected $fillable = [
        'device_id',
        'slot_key',
        'on_time',
        'duration',
        'sector',
        'name',
        'days',
        'is_active',
    ];

    protected $casts = [
        'days' => 'array',
        'is_active' => 'boolean',
        'duration' => 'integer',
        'sector' => 'integer',
    ];

    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }

    /**
     * Parse schedule string from device format
     * Format: "14:27-1-2-PUPUK  Min, Sen, Sel, Rab, Kam, Jum, Sab"
     * or empty: "_:_-0-0-_  -"
     */
    public static function parseFromDevice(string $raw): array
    {
        $rawTrim = trim($raw);
        $result = [
            'is_active' => false,
            'on_time' => null,
            'duration' => 0,
            'sector' => 0,
            'name' => null,
            'days' => [],
            'raw_time_empty' => false,
        ];

        // Empty schedule check (misal: _:_, --:--, kosong, atau string kosong)
        if (str_starts_with($rawTrim, '_:_') || 
            str_starts_with($rawTrim, '--') || 
            str_contains(strtolower($rawTrim), 'kosong') || 
            empty($rawTrim)) {
            return $result;
        }

        // Format: "HH:MM-DURATION-SECTOR-NAME  DAYS"
        // Example 1: "06:30-15-1-BAKU  Min, Sen, Sel, Rab, Kam, Jum, Sab"
        // Example 2 (real hardware): ":-5-1-BAKU  Min, Sen, Sel, Rab, Kam, Jum, Sab"
        // Example 3 (empty hardware): ":-0-0-_  -"

        // Split by first occurrence of double space to separate name from days
        $parts = preg_split('/\s{2,}/', $rawTrim, 2);

        if (count($parts) >= 2) {
            // Parse days from second part
            $daysStr = trim($parts[1]);
            if (!empty($daysStr) && $daysStr !== '-') {
                $days = array_values(array_filter(array_map('trim', explode(',', $daysStr))));
                $result['days'] = $days;
            }
        }

        // Parse first part: "HH:MM-DURATION-SECTOR-NAME"
        $mainPart = $parts[0] ?? '';
        $segments = explode('-', $mainPart, 4);

        if (count($segments) >= 4) {
            $timeStr = trim($segments[0]);
            if (preg_match('/^(\d{1,2}):(\d{1,2})$/', $timeStr, $tm)) {
                $result['on_time'] = sprintf('%02d:%02d:00', (int)$tm[1], (int)$tm[2]);
            } elseif (preg_match('/^:(\d{1,2})$/', $timeStr, $tm)) {
                $result['on_time'] = sprintf('00:%02d:00', (int)$tm[1]);
            } elseif (preg_match('/^(\d{1,2}):?$/', $timeStr, $tm)) {
                $result['on_time'] = sprintf('%02d:00:00', (int)$tm[1]);
            } else {
                $result['on_time'] = '00:00:00';
                $result['raw_time_empty'] = true;
            }

            // Duration
            $result['duration'] = (int) ($segments[1] ?? 0);

            // Sector
            $result['sector'] = (int) ($segments[2] ?? 0);

            // Name
            $result['name'] = trim($segments[3] ?? '');

            // Validasi keaktifan jadwal dari parameter hardware
            $hasValidDuration = $result['duration'] > 0;
            $hasValidName = !empty($result['name']) && $result['name'] !== '_' && $result['name'] !== '-' && strtolower($result['name']) !== 'kosong';
            $hasValidDays = !empty($result['days']) && $result['days'] !== ['-'];

            $result['is_active'] = $hasValidDuration && $hasValidName && $hasValidDays;
            if (!$result['is_active']) {
                $result['on_time'] = null;
            }
        }

        return $result;
    }

    /**
     * Get display-friendly time
     */
    public function getDisplayTimeAttribute(): string
    {
        if (!$this->on_time) {
            return '-';
        }
        return substr($this->on_time, 0, 5); // HH:MM only
    }

    /**
     * Get display-friendly days
     */
    public function getDisplayDaysAttribute(): string
    {
        if (empty($this->days)) {
            return '-';
        }
        return implode(', ', $this->days);
    }
}
