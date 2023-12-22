import { Outlet } from "react-router";
import { Menu } from "../components/menu/menu";
import "./layouts.sass";

export function DefaultLayout() {
  return (
    <div className="default-layout">
      <Menu />
      <main className="default-layout__main">
        <Outlet />
      </main>
    </div>
  );
}
