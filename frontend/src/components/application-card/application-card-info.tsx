type ApplicationCardInfoProps = {
  label: string;
  value: string | number;
};

export function ApplicationCardInfo({ label, value }: ApplicationCardInfoProps) {
  return (
    <div className="application-card-info">
      <p className="application-card-info__label">{label}</p>
      <p className="application-card-info__value">{value}</p>
    </div>
  );
}
