import { Outlet } from "react-router";
import "./layouts.sass";

export function GuestLayout() {
  return (
    <div className="guest-layout">
      <Outlet />
    </div>
  );
}
