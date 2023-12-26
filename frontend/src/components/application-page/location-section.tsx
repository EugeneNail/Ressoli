import { Address } from "../../models/address";
import { Map, Marker, ZoomControl } from "pigeon-maps";
import { LocationSectionAttribute } from "./location-section-attribute";

type LocationSectionProps = {
  address: Address;
};

export function LocationSection({ address }: LocationSectionProps) {
  return (
    <div className="application-page__section location-section" id="location">
      <div className="location-section__attributes">
        <LocationSectionAttribute icon="house" value={address.number} />
        <LocationSectionAttribute icon="add_road" value={address.street + " " + address.typeOfStreet} />
        {address.unit != null && <LocationSectionAttribute icon="apartment" value={address.unit} />}
        <LocationSectionAttribute icon="map" value={address.city} />
        {address.postalCode != null && <LocationSectionAttribute icon="mail" value={address.postalCode} />}
      </div>
      <div className="location-section__map">
        <Map
          defaultZoom={15}
          touchEvents={false}
          mouseEvents={false}
          center={[address.latitude, address.longitude]}
          animate={true}
        >
          <ZoomControl />
          <Marker width={40} color="red" />
        </Map>
      </div>
    </div>
  );
}
