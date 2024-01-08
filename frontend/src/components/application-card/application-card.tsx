import { CardApplication } from "../../models/card-application";
import { CardLandParcel } from "../../models/card-land-parcel";
import "./application-card.sass";
import { ApplicationCardAttribute } from "./application-card-attribute";
import { ApplicationCardInfo } from "./application-card-info";
import classNames from "classnames";
import { CardHouse } from "../../models/card-house";
import { CardApartment } from "../../models/card-apartment";
import { Link } from "react-router-dom";
import { Format } from "../../services/format";
import { env } from "../../env";

type ApplicationCardProps = {
  application: CardApplication<CardLandParcel | CardApartment | CardHouse>;
};

export function ApplicationCard({ application }: ApplicationCardProps) {
  function getAttributes() {
    const { type } = application.applicable;
    if (type == "Land Parcel") {
      return getLandParcelAttributes();
    } else if (type == "House") {
      return getHouseAttributes();
    } else if (type == "Apartment") {
      return getApartmentAttributes();
    }
  }

  function getLandParcelAttributes() {
    const { area, hasWater, hasGas, hasElectricity } = application.applicable as unknown as CardLandParcel;
    return (
      <>
        <ApplicationCardAttribute value={area + " m²"} icon="zoom_out_map" />
        {hasWater && <ApplicationCardAttribute icon="water_drop" />}
        {hasGas && <ApplicationCardAttribute icon="local_fire_department" />}
        {hasElectricity && <ApplicationCardAttribute icon="flash_on" />}
      </>
    );
  }

  function getHouseAttributes() {
    const { area, landArea, roomCount } = application.applicable as unknown as CardHouse;
    return (
      <>
        <ApplicationCardAttribute value={area + " m²"} icon="zoom_out_map" />
        <ApplicationCardAttribute value={landArea + " m²"} icon="outdoor_garden" />
        <ApplicationCardAttribute value={roomCount} icon="king_bed" />
      </>
    );
  }

  function getApartmentAttributes() {
    const { area, roomCount, hasGarage, level, levelCount } = application.applicable as unknown as CardApartment;
    return (
      <>
        <ApplicationCardAttribute value={area + " m²"} icon="zoom_out_map" />
        <ApplicationCardAttribute value={roomCount} icon="king_bed" />
        <ApplicationCardAttribute value={level + " / " + levelCount} icon="floor" />
        {hasGarage && <ApplicationCardAttribute icon="garage" />}
      </>
    );
  }

  function getPreview() {
    return application.preview !== null ? `${env.API_URL}/photos/${application.preview}` : "/img/no-photo.png";
  }

  return (
    <Link target="_blank" to={application.id.toString()} className="application-card">
      <p className={classNames("application-card__status", { archived: !application.isActive })}>
        {application.isActive ? "Active" : "Archived"}
      </p>
      <img src={getPreview()} className="application-card__photo" />
      <div className="application-card__main-group">
        <h3 className="application-card__title">
          {application.applicable.type} for {application.contract}
        </h3>
        <div className="application-card__price-label">Property price</div>
        <p className="application-card__address">{Format.toFullAddress(application.address)}</p>
        <div className="application-card__price">{application.price}</div>
      </div>
      <div className="application-card__attribute-group">{getAttributes()}</div>
      <div className="application-card__info-group">
        <ApplicationCardInfo label="Contract" value={application.contract} />
        <ApplicationCardInfo label="Date" value={Format.toShortDate(application.date)} />
        <ApplicationCardInfo label="Client" value={application.client} />
      </div>
    </Link>
  );
}
