import { Outlet } from "react-router";
import { Menu } from "../components/menu/menu";
import "./layouts.sass";
import { Notifications } from "../components/notifications/notifications";

export function DefaultLayout() {
  return (
    <div className="default-layout">
      <Menu />
      <main className="default-layout__main">
        <Notifications>
          <Outlet />
        </Notifications>
      </main>
    </div>
  );
}
