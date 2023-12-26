import { Icon } from "../icon/icon";

type LocationSectionAttributeProps = {
  icon: string;
  value: string | number;
};

export function LocationSectionAttribute({ icon, value }: LocationSectionAttributeProps) {
  return (
    <div className="location-section-attribute">
      <Icon className="location-section-attribute__icon" name={icon} />
      <p className="location-section-attribute__value">{value}</p>
    </div>
  );
}
