<?php

namespace App\Services;

use App\Models\Apartment;
use App\Models\Application;
use App\Models\House;
use App\Models\LandParcel;
use App\Models\Support\ApplicationDataNode;
use App\Models\User;

class Statistics {

    public function collectCurrentMonth(User $user): array {
        $map = [
            House::class => "Houses",
            Apartment::class => "Apartments",
            LandParcel::class => "Parcels"
        ];

        return Application::query()
            ->where("user_id", $user->id)
            ->whereDate("created_at", ">=", $this->getTimestamp("Y-m-01"))
            ->whereDate("created_at", "<=", $this->getTimestamp("Y-m-t", "23:59:59"))
            ->get()
            ->groupBy("applicable_type")
            ->map(fn ($applications, $applicable) => new ApplicationDataNode(
                $map[$applicable],
                $applications->where("is_active", true)->count(),
                $applications->where("is_active", false)->count(),
                $applications->where("is_active", false)->sum("price")
            ))
            ->flatten()
            ->toArray();
    }

    public function collectMonthly(User $user = null): array {
        return Application::query()
            ->where("user_id", $user->id)
            ->whereDate("created_at", ">=", $this->getTimestamp("Y-01-01"))
            ->whereDate("created_at", "<=", $this->getTimestamp("Y-m-t", "23:59:59"))
            ->orderBy("created_at")
            ->get()
            ->groupBy(fn ($application) => $application->created_at->month)
            ->map(fn ($applications, $month) => new ApplicationDataNode(
                $month,
                $applications->where("is_active", true)->count(),
                $applications->where("is_active", false)->count(),
                $applications->where("is_active", false)->sum("price")
            ))
            ->flatten()
            ->toArray();
    }

    private function getTimestamp(string $format, string $time = "00:00:00"): string {
        return date($format) . " " . $time;
    }
}
