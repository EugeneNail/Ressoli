import { LandParcel } from "../../models/land-parcel";
import { ApplicableSectionAttribute } from "./applicable-section-attribute";

type LandParcelSectionProps = {
  landParcel: LandParcel;
};

export function LandParcelSection({ landParcel }: LandParcelSectionProps) {
  return (
    <section className="application-page__section applicable-section">
      <div className="applicable-section__group">
        <ApplicableSectionAttribute icon="zoom_out_map" label="Area" value={landParcel.area + " m²"} />
      </div>
      <div className="applicable-section__group">
        <ApplicableSectionAttribute icon="water_drop" label="Water" value={landParcel.water} />
        <ApplicableSectionAttribute icon="local_fire_department" label="Gas" value={landParcel.gas} />
        <ApplicableSectionAttribute icon="flash_on" label="Electricity" value={landParcel.electricity} />
        <ApplicableSectionAttribute icon="water_pump" label="Sewer" value={landParcel.sewer} />
      </div>
    </section>
  );
}
