import classNames from "classnames";
import "./custom-control.sass";

type RadioProps = {
  options: string[];
  onChange: (value: string) => void;
  selected: string;
};

export function Radio({ options, onChange, selected }: RadioProps) {
  return (
    <div className="radio">
      {options.map((option) => (
        <div
          key={option}
          className={classNames("radio__option", { selected: option === selected })}
          onClick={() => onChange(option)}
        >
          {option}
        </div>
      ))}
    </div>
  );
}
