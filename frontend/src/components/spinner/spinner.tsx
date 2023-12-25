import classNames from "classnames";
import { Icon } from "../icon/icon";
import "./spinner.sass";

type SpinnerProps = {
  className?: string;
};

export function Spinner({ className }: SpinnerProps) {
  return (
    <div className={classNames("spinner", className)}>
      <Icon className="spinner__icon" name="autorenew" />
    </div>
  );
}
