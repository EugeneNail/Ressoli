import classNames from "classnames";
import "./custom-control.sass";
import { useState, FocusEvent, useRef, useEffect } from "react";
import { HelperText } from "./helper-text";
import { Icon } from "../icon/icon";
import { ControlProps } from "./control-props";

type NumericProps = ControlProps & {
  min?: number;
  max?: number;
  step: number;
  precision?: number;
};

export function Numeric({
  name,
  label,
  initialValue = "",
  icon,
  helperText = "",
  errors,
  resetError,
  min = 0,
  max,
  step = 1,
  precision = 0,
}: NumericProps) {
  const [isActive, setActive] = useState(false);
  const intervalRef = useRef<number>(0);
  const timeoutRef = useRef<number>(0);
  const [isInvalid, setInvalid] = useState(false);
  const ref = useRef<HTMLInputElement>(document.createElement("input") as HTMLInputElement);
  const isDirty = useRef(false);

  useEffect(() => {
    setInvalid(errors.length > 0);
    if (!isDirty.current && initialValue != "") {
      setActive(true);
      isDirty.current = true;
    }
  }, [errors]);

  function handleBlur(event: FocusEvent<HTMLInputElement>) {
    setActive(event.target.value.length > 0);
    resetError?.(name);
  }

  function add() {
    resetError?.(name);
    setActive(true);
    adjustRepeatedly(1);
  }

  function remove() {
    resetError?.(name);
    setActive(true);
    adjustRepeatedly(-1);
  }

  function adjustRepeatedly(vector: -1 | 1) {
    adjustByStep(vector);
    intervalRef.current = setInterval(() => adjustByStep(vector), 100);

    timeoutRef.current = setTimeout(() => {
      clearInterval(intervalRef.current);
      intervalRef.current = setInterval(() => adjustByStep(vector), 33);
    }, 2000);
  }

  function adjustByStep(vector: -1 | 1) {
    const { current: input } = ref;
    const initialValue: number = input.value.length > 0 ? parseFloat(input.value) : 0;
    const newValue = initialValue + step * vector;

    if (newValue < min || (max != null && newValue > max)) {
      return;
    }

    input.value = newValue.toFixed(precision).toString();
  }

  function resetActions() {
    clearTimeout(timeoutRef.current);
    clearInterval(intervalRef.current);
  }

  return (
    <div className={classNames("control", { invalid: isInvalid }, { active: isActive })}>
      <label htmlFor={name} className="control__main-area" onMouseLeave={resetActions}>
        <div className="control__icon-container">
          <Icon className="control__icon" name={icon} />
        </div>
        <p className="control__label">{label}</p>
        <input
          ref={ref}
          autoComplete="off"
          type="number"
          className={"control__input"}
          name={name}
          id={name}
          defaultValue={initialValue}
          onWheel={(e) => e?.currentTarget?.blur()}
          onInput={() => setActive(true)}
          onFocus={() => setActive(true)}
          onBlur={handleBlur}
        />
        <div className="control__button control__icon-container" onMouseDown={add} onMouseUp={resetActions}>
          <Icon className="control__icon" name="add" />
        </div>
        <div className="control__button control__icon-container" onMouseDown={remove} onMouseUp={resetActions}>
          <Icon className="control__icon" name="remove" />
        </div>
      </label>
      <HelperText errors={errors} text={helperText} />
    </div>
  );
}
