import { NavLink } from "react-router-dom";
import { Icon } from "../icon/icon";

type MenuLinkProps = {
  icon: string;
  to: string;
  label: string;
};

export function MenuLink({ icon, label, to }: MenuLinkProps) {
  return (
    <NavLink className="menu-link" to={to}>
      <Icon className="menu-link__icon" name={icon} />
      <p className="menu-link__label">{label}</p>
    </NavLink>
  );
}
