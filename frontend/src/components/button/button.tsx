import "./button.sass";
import classNames from "classnames";
import { Link } from "react-router-dom";

export enum ButtonStyle {
  primary = "primary",
  secondary = "secondary",
  tertiary = "tertiary",
}

type ButtonProps = {
  text?: string;
  style?: ButtonStyle;
  wide?: boolean;
  action?: () => void;
  className?: string;
  to?: string | number;
};

function Button({ text, style = ButtonStyle.primary, wide, action, className, to }: ButtonProps) {
  const classList = classNames("button", { wide: wide }, className, style);

  function handleClick() {
    action?.();
  }

  return (
    <>
      {to && (
        <Link className={classList} target="_blank" to={to.toString()}>
          {text}
        </Link>
      )}
      {!to && (
        <button onClick={handleClick} className={classList}>
          {text}
        </button>
      )}
    </>
  );
}

export default Button;
