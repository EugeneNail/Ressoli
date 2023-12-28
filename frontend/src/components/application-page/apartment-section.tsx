import { Apartment } from "../../models/apartment";
import { ApplicableSectionAttribute } from "./applicable-section-attribute";

type ApartmentSectionProps = {
  apartment: Apartment;
};

export function ApartmentSection({ apartment }: ApartmentSectionProps) {
  return (
    <section className="application-page__section applicable-section">
      <div className="applicable-section__group">
        <ApplicableSectionAttribute icon="zoom_out_map" label="Area" value={apartment.area + " m²"} />
      </div>
      {apartment.hasWater && apartment.hasGas && apartment.hasElectricity && apartment.hasSewer && (
        <div className="applicable-section__group">
          {apartment.hasWater && <ApplicableSectionAttribute icon="water_drop" label="Water" />}
          {apartment.hasGas && <ApplicableSectionAttribute icon="local_fire_department" label="Gas" />}
          {apartment.hasElectricity && <ApplicableSectionAttribute icon="flash_on" label="Electricity" />}
          {apartment.hasSewer && <ApplicableSectionAttribute icon="water_pump" label="Sewer" />}
        </div>
      )}
      <div className="applicable-section__group">
        <ApplicableSectionAttribute icon="garage_door" label="Walls" value={apartment.walls} />
        <ApplicableSectionAttribute icon="home_and_garden" label="Condition" value={apartment.condition} />
        <ApplicableSectionAttribute icon="height" label="Ceiling" value={apartment.ceiling} />
        <ApplicableSectionAttribute icon="floor" label="Level" value={`${apartment.level} / ${apartment.levelCount}`} />
      </div>
      <div className="applicable-section__group">
        {apartment.hasHeating && <ApplicableSectionAttribute icon="heat" label="Heating" />}
        {apartment.hasHotWater && <ApplicableSectionAttribute icon="water_heater" label="Hot water" />}
        <ApplicableSectionAttribute icon="shower" label="Bath" value={apartment.bath} />
        <ApplicableSectionAttribute icon="bathroom" label="Bathroom" value={apartment.bathroom} />
      </div>
      <div className="applicable-section__group">
        <ApplicableSectionAttribute icon="zoom_out_map" label="Area" value={apartment.area} />
        <ApplicableSectionAttribute icon="king_bed" label="Room count" value={apartment.roomCount} />

        {apartment.hasLoggia && <ApplicableSectionAttribute icon="sensor_window" label="Loggia" />}
        {apartment.hasBalcony && <ApplicableSectionAttribute icon="balcony" label="Balcony" />}
        {apartment.hasGarage && <ApplicableSectionAttribute icon="garage" label="Garage" />}
      </div>
      {apartment.hasGarbageChute && apartment.hasElevator && apartment.isCorner && (
        <div className="applicable-section__group">
          {apartment.hasGarbageChute && <ApplicableSectionAttribute icon="recycling" label="Garbage chute" />}
          {apartment.hasElevator && <ApplicableSectionAttribute icon="elevator" label="Elevator" />}
          {apartment.isCorner && <ApplicableSectionAttribute icon="dashboard_customize" label="Corner" />}
        </div>
      )}
    </section>
  );
}
