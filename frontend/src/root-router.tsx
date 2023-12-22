import { BrowserRouter, Route, Routes } from "react-router-dom";
import { GuestLayout } from "./layouts/guest-layout";
import { DefaultLayout } from "./layouts/default-layout";
import { LoginPage } from "./pages/login-page";

export function RootRouter() {
  return (
    <BrowserRouter>
      <Routes>
        <Route element={<GuestLayout />}>
          <Route path="/login" element={<LoginPage />} />
        </Route>
        <Route path="/houses" element={<DefaultLayout />}></Route>
      </Routes>
    </BrowserRouter>
  );
}
