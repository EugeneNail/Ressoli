import { Icon } from "../icon/icon";

type ApplicationCardAttributeProps = {
  icon: string;
  value?: string | number;
};

export function ApplicationCardAttribute({ icon, value }: ApplicationCardAttributeProps) {
  return (
    <div className="application-card-attribute">
      <Icon className="application-card-attribute__icon" name={icon} />
      {value && <p className="application-card-attribute__value">{value}</p>}
    </div>
  );
}
