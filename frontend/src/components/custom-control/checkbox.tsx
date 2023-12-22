import { useEffect, useRef } from "react";
import { Icon } from "../icon/icon";

type CheckboxProps = {
  label: string;
  name: string;
  checked?: boolean;
};

export function Checkbox({ label, name, checked = false }: CheckboxProps) {
  useEffect(() => {}, []);
  const ref = useRef<HTMLInputElement>(document.createElement("input") as HTMLInputElement);

  useEffect(() => {
    ref.current.checked = checked;
  }, []);

  return (
    <label htmlFor={name} className="checkbox">
      <div className="checkbox__square">
        <Icon className="checkbox__icon" name="check" />
      </div>
      <input ref={ref} name={name} id={name} type="checkbox" className="checkbox__input" />
      <p className="checkbox__label">{label}</p>
    </label>
  );
}
