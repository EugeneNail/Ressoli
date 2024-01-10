import classNames from "classnames";
import "./custom-control.sass";
import { ChangeEvent } from "react";

type RangeProps = {
  min: number;
  max: number;
  step: number;
  leftValue: number;
  onChangeLeft: (value: number) => void;
  rightValue: number;
  onChangeRight: (value: number) => void;
  className?: string;
};

export function Range({ min, max, step, leftValue, rightValue, className, onChangeLeft, onChangeRight }: RangeProps) {
  function handleChangeLeft(event: ChangeEvent<HTMLInputElement>) {
    const value = +event.target.value;
    if (value > rightValue) {
      onChangeRight(value);
    }
    onChangeLeft(value);
  }

  function handleChangeRight(event: ChangeEvent<HTMLInputElement>) {
    const value = +event.target.value;
    if (value < leftValue) {
      onChangeLeft(value);
    }
    onChangeRight(value);
  }

  return (
    <div className={classNames("range", className)}>
      <div
        className="range__progress"
        style={{
          width: `${(((rightValue - leftValue) / max) * 100).toFixed(2)}%`,
          left: ((leftValue / max) * 100).toFixed(2) + "%",
        }}
      />
      <input
        type="range"
        value={leftValue}
        min={min}
        max={max}
        step={step}
        className="range__slider left"
        onChange={handleChangeLeft}
      />
      <input
        type="range"
        value={rightValue}
        min={min}
        max={max}
        step={step}
        className="range__slider right"
        onChange={handleChangeRight}
      />
    </div>
  );
}
