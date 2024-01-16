<?php

namespace App\Services;

use App\Models\Apartment;
use App\Models\Application;
use App\Models\House;
use App\Models\LandParcel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class ApplicationFilter {

    private Builder $query;

    private Request $request;


    public function __construct(Request $request) {
        $this->request = $request;
        $this->query = Application::query()->with(["client", "address", "applicable", "photos"]);
    }


    public function query() {
        return $this->query;
    }


    public function byTypes(): static {
        if (!$this->request->has("types")) {
            return $this;
        }

        $types = $this->request->input("types");
        $map = [
            "land-parcels" => LandParcel::class,
            "houses" => House::class,
            "apartments" => Apartment::class
        ];
        $modelClasses = collect($types)->map(fn ($type) => $map[$type]);
        $this->query->whereIn("applicable_type", $modelClasses);


        return $this;
    }


    public function byOwned(): static {
        if (!$this->request->has('owned')) {
            return $this;
        }
        $this->query->where("user_id", $this->request->user()->id);

        return $this;
    }


    public function byStatus(): static {
        if (!$this->request->has("status")) {
            return $this;
        }

        $status = $this->request->input("status");
        $map = ["Active" => true, "Archived" => false];
        $expectedStatus = $map[$status];

        $this->query->where("is_active", $expectedStatus);
        return $this;
    }


    public function byPriceRange(): static {
        if ($this->request->has("start-price")) {
            $startPrice = $this->request->input("start-price");
            $this->query->where("price", ">=", $startPrice);
        }

        if ($this->request->has("end-price")) {
            $endPrice = $this->request->input("end-price");
            $this->query->where("price", "<=", $endPrice);
        }

        return $this;
    }


    public function byAreaRange(): static {
        if ($this->request->has("start-area")) {
            $startArea = $this->request->input("start-area");
            $this->query->whereRelation("applicable", "area", ">=", $startArea);
        }

        if ($this->request->has("end-area")) {
            $endArea = $this->request->input("end-area");
            $this->query->whereRelation("applicable", "area", "<=", $endArea);
        }

        return $this;
    }


    public function byDateRange(): static {
        if ($this->request->has("start-date")) {
            $startDate = $this->request->input("start-date");
            $this->query = $this->query->where("created_at", ">=", $startDate . " 00:00:00");
        }
        if ($this->request->has("end-date")) {
            $endDate = $this->request->input("end-date");
            $this->query = $this->query->where("created_at", "<=", $endDate . " 23:59:59");
        }

        return $this;
    }


    public function byContract(): static {
        if (!$this->request->has("contract")) {
            return $this;
        }

        $contract = $this->request->input("contract");
        $this->query->where("contract", $contract);

        return $this;
    }

    public function byPhotos(): static {
        if ($this->request->has("no-photos")) {
            $this->query->doesntHave("photos");
        }

        return $this;
    }
}
