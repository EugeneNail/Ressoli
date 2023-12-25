<?php

namespace App\Http\Resources;

use App\Models\Apartment;
use App\Models\House;
use App\Models\LandParcel;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CardApplicationResource extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array {
        return [
            "id" => $this->id,
            "is_active" => $this->is_active,
            "address" => $this->address,
            "price" => $this->price,
            "applicable" => $this->selectApplicable(),
            "date" => $this->created_at,
            "client" => $this->client->name,
            "contract" => $this->contract,
            "has_mortgage" => $this->hasMortgage
        ];
    }

    private function selectApplicable() {
        $type = $this->applicable_type;

        if ($type === House::class) {
            return $this->getHouseAttributes();
        } elseif ($type === Apartment::class) {
            return $this->getApartmentAttributes();
        } elseif ($type === LandParcel::class) {
            return $this->getLandParcelAttributes();
        }
    }

    private function getHouseAttributes(): array {
        return [
            "type" => "House",
            "area" => $this->applicable->area,
            "land_area" => $this->applicable->land_area,
            "room_count" => $this->applicable->room_count
        ];
    }

    private function getApartmentAttributes(): array {
        return [
            "type" => "Apartment",
            "area" => $this->applicable->area,
            "room_count" => $this->applicable->room_count,
            "has_garage" => $this->applicable->has_garage,
            "level" => $this->applicable->level,
            "level_count" => $this->applicable->level_count,
        ];
    }

    private function getLandParcelAttributes(): array {
        return [
            "type" => "Land Parcel",
            "area" => $this->applicable->area,
            "has_water" => $this->applicable->water !== "None",
            "has_gas" => $this->applicable->gas !== "None",
            "has_electricity" => $this->applicable->electricity !== "None",
        ];
    }
}
