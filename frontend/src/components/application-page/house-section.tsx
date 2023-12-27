import { House } from "../../models/House";
import { ApplicableSectionAttribute } from "./applicable-section-attribute";

type HouseSectionProps = {
  house: House;
};

export function HouseSection({ house }: HouseSectionProps) {
  return (
    <section className="application-page__section applicable-section">
      <div className="applicable-section__group">
        <ApplicableSectionAttribute icon="zoom_out_map" label="Area" value={house.area} />
        <ApplicableSectionAttribute icon="king_bed" label="Room count" value={house.roomCount} />
        <ApplicableSectionAttribute icon="kitchen" label="Kitchen area" value={house.kitchenArea} />
        <ApplicableSectionAttribute icon="outdoor_garden" label="Land area" value={house.landArea} />
      </div>
      <div className="applicable-section__group">
        <ApplicableSectionAttribute icon="water_drop" label="Water" value={house.water} />
        <ApplicableSectionAttribute icon="local_fire_department" label="Gas" value={house.gas} />
        <ApplicableSectionAttribute icon="flash_on" label="Electricity" value={house.electricity} />
        <ApplicableSectionAttribute icon="water_pump" label="Sewer" value={house.sewer} />
      </div>
      <div className="applicable-section__group">
        <ApplicableSectionAttribute icon="garage_door" label="Walls" value={house.walls} />
        <ApplicableSectionAttribute icon="home_and_garden" label="Condition" value={house.condition} />
        <ApplicableSectionAttribute icon="roofing" label="Roof" value={house.roof} />
        <ApplicableSectionAttribute icon="foundation" label="Floor" value={house.floor} />
        <ApplicableSectionAttribute icon="floor" label="Level count" value={house.levelCount} />
        {house.hasGarage && <ApplicableSectionAttribute icon="garage" label="Garage" />}
      </div>
      <div className="applicable-section__group">
        <ApplicableSectionAttribute icon="water_heater" label="Hot water" value={house.hotWater} />
        <ApplicableSectionAttribute icon="heat" label="Heating" value={house.heating} />
        <ApplicableSectionAttribute icon="shower" label="Bath" value={house.bath} />
        <ApplicableSectionAttribute icon="bathroom" label="Bathroom" value={house.bathroom} />
      </div>
    </section>
  );
}
