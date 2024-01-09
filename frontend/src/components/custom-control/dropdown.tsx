import classNames from "classnames";
import { useState, FocusEvent, useEffect, useRef } from "react";
import { HelperText } from "./helper-text";
import { Icon } from "../icon/icon";
import { ControlProps } from "./control-props";

type DropdownProps = ControlProps & {
  options: string[];
};

export function Dropdown({
  name,
  label,
  resetError,
  options = [],
  initialValue = "",
  icon,
  helperText = "",
  errors,
}: DropdownProps) {
  const [isActive, setActive] = useState(initialValue?.length > 0);
  const [isInvalid, setInvalid] = useState(false);
  const isDirty = useRef(false);

  useEffect(() => {
    setInvalid(errors.length > 0);
    if (!isDirty.current && initialValue != "") {
      setActive(true);
      isDirty.current = true;
    }
  }, [errors, initialValue]);

  function handleBlur(event: FocusEvent<HTMLSelectElement>) {
    setActive(event.target.value.length > 0);
    resetError?.(name);
  }

  function handleChange() {
    setActive(true);
    resetError?.(name);
  }

  return (
    <div className={classNames("control", { active: isActive }, { invalid: isInvalid })}>
      <label htmlFor={name} className="control__main-area dropdown">
        <div className="control__icon-container">
          <Icon className="control__icon" name={icon} />
        </div>
        <select
          onBlur={handleBlur}
          onInput={() => setActive(true)}
          onChange={handleChange}
          name={name}
          id={name}
          className="control__input"
        >
          <option value={initialValue} className="dropdown__option hidden">
            {initialValue}
          </option>
          {options.map((option, index) => (
            <option key={index} value={option} className="dropdown__option">
              {option}
            </option>
          ))}
        </select>
        <p className="control__label">{label}</p>
        <div className="control__button control__icon-container">
          <Icon className="control__icon dropdown__icon affected" name="expand_more" />
        </div>
      </label>
      <HelperText errors={errors} text={helperText} />
    </div>
  );
}
