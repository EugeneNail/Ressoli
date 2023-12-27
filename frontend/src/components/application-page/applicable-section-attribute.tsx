import { Icon } from "../icon/icon";

type ApplicableSectionAttributeProps = {
  icon: string;
  label: string;
  value?: string | number;
};

export function ApplicableSectionAttribute({ icon, label, value }: ApplicableSectionAttributeProps) {
  return (
    <div className="applicable-section-attribute">
      <Icon className="applicable-section-attribute__icon" name={icon} />
      <p className="applicable-section-attribute__label" style={{ gridRow: value ? "1 / 2" : "1 / -1" }}>
        {label}
      </p>

      {value && <p className="applicable-section-attribute__value">{value}</p>}
    </div>
  );
}
