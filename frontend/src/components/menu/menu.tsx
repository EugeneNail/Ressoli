import { useNavigate } from "react-router";
import { Icon } from "../icon/icon";
import { MenuLink } from "./menu-link";
import "./menu.sass";
import api from "../../services/api";

export function Menu() {
  const navigate = useNavigate();

  async function logout() {
    const { status } = await api.post("/logout");

    if (status === 204) {
      navigate("/login");
    }
  }

  return (
    <nav className="menu">
      <div className="menu__logo">
        <img src="/img/logo.svg" className="menu__icon" />
      </div>
      <div className="menu__links">
        <MenuLink label="Dashboard" to="/dashboard" icon="grid_view" />
        <MenuLink label="Houses" to="/houses?types[]=houses" icon="house" />
        <MenuLink label="Parcels" to="/land-parcels?types[]=land-parcels" icon="map" />
        <MenuLink label="Apartments" to="/apartments?types[]=apartments" icon="apartment" />
      </div>
      <Icon name="logout" onClick={logout} className="menu__logout-button" />
    </nav>
  );
}
