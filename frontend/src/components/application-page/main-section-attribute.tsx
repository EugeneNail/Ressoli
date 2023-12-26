import { Icon } from "../icon/icon";

type MainSectionAttributeProps = {
  icon: string;
  value: string | number;
};

export function MainSectionAttribute({ icon, value }: MainSectionAttributeProps) {
  return (
    <div className="main-section-attribute">
      <Icon className="main-section-attribute" name={icon} />
      <p className="main-section-attribute__value">{value}</p>
    </div>
  );
}
