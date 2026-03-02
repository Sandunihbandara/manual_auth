<?php

namespace App\Console\Commands;

use App\Models\MaintenanceSchedule;
use Illuminate\Console\Command;

class SendMaintenanceReminders extends Command
{
    protected $signature = 'maintenance:remind';
    protected $description = 'Send reminders for upcoming instrument maintenance';

    public function handle(): int
    {
        $due = MaintenanceSchedule::where('reminded', false)
            ->whereNotNull('remind_at')
            ->where('remind_at', '<=', now())
            ->whereIn('status', ['scheduled','in_progress'])
            ->get();

        // For now: just mark reminded + log output
        foreach ($due as $m) {
            // Later: send notification to staff/admin (database/email)
            $m->update(['reminded' => true]);
            $this->info("Reminder: Instrument #{$m->instrument_id} maintenance {$m->type} at {$m->starts_at}");
        }

        return self::SUCCESS;
    }
}