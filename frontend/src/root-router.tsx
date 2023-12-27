import { BrowserRouter, Route, Routes } from "react-router-dom";
import { GuestLayout } from "./layouts/guest-layout";
import { DefaultLayout } from "./layouts/default-layout";
import { LoginPage } from "./pages/login-page";
import { SignupPage } from "./pages/signup-page";
import { CreateLandParcelPage } from "./pages/create-land-parcel-page";
import { LandParcelsPage } from "./pages/land-parcels-page";
import { LandParcelPage } from "./pages/land-parcel-page";
import { EditLandParcelPage } from "./pages/edit-land-parcel-page";

export function RootRouter() {
  return (
    <BrowserRouter>
      <Routes>
        <Route element={<GuestLayout />}>
          <Route path="/login" element={<LoginPage />} />
          <Route path="/signup" element={<SignupPage />} />
        </Route>
        <Route element={<DefaultLayout />}>
          <Route path="/dashboard" />
          <Route path="/land-parcels">
            <Route path="/land-parcels" element={<LandParcelsPage />} />
            <Route path="/land-parcels/new" element={<CreateLandParcelPage />} />
            <Route path="/land-parcels/:id" element={<LandParcelPage />} />
            <Route path="/land-parcels/:id/edit" element={<EditLandParcelPage />} />
          </Route>
        </Route>
      </Routes>
    </BrowserRouter>
  );
}
