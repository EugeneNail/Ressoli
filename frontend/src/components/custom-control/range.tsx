import classNames from "classnames";
import "./custom-control.sass";
import { ChangeEvent } from "react";

type RangeProps = {
  min: number;
  max: number;
  step: number;
  startValue: number;
  updateStart: (value: number) => void;
  endValue: number;
  updateEnd: (value: number) => void;
  className?: string;
};

export function Range({ min, max, step, startValue, endValue, className, updateStart, updateEnd }: RangeProps) {
  function handleStartChange(event: ChangeEvent<HTMLInputElement>) {
    const value = +event.target.value;
    if (value > endValue) {
      updateEnd(value);
    }
    updateStart(value);
  }

  function handleEndChange(event: ChangeEvent<HTMLInputElement>) {
    const value = +event.target.value;
    if (value < startValue) {
      updateStart(value);
    }
    updateEnd(value);
  }

  return (
    <div className={classNames("range", className)}>
      <div
        className="range__progress"
        style={{
          width: `${(((endValue - startValue) / max) * 100).toFixed(2)}%`,
          left: ((startValue / max) * 100).toFixed(2) + "%",
        }}
      />
      <input
        type="range"
        value={startValue}
        min={min}
        max={max}
        step={step}
        className="range__slider start"
        onChange={handleStartChange}
      />
      <input
        type="range"
        value={endValue}
        min={min}
        max={max}
        step={step}
        className="range__slider end"
        onChange={handleEndChange}
      />
    </div>
  );
}
