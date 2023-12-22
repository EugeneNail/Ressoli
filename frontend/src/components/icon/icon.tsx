import classNames from "classnames";
import "./icon.sass";

type IconProps = {
  name: string;
  filled?: boolean;
  className?: string;
  onClick?: () => void;
};

export function Icon({ name, className, filled = false, onClick }: IconProps) {
  return (
    <span className={classNames("icon", "material-symbols-rounded", className, { filled: filled })} onClick={onClick}>
      {name}
    </span>
  );
}
