import { BrowserRouter, Route, Routes } from "react-router-dom";
import { GuestLayout } from "./layouts/guest-layout";
import { DefaultLayout } from "./layouts/default-layout";
import { LoginPage } from "./pages/login-page";
import { SignupPage } from "./pages/signup-page";
import { CreateLandParcelPage } from "./pages/editable-application-page/create-application-page/create-land-parcel-page";
import { LandParcelsPage } from "./pages/applications-page/land-parcels-page";
import { LandParcelPage } from "./pages/application-page/land-parcel-page";
import { EditLandParcelPage } from "./pages/editable-application-page/edit-application-page/edit-land-parcel-page";
import { HousesPage } from "./pages/applications-page/houses-page";
import { CreateHousePage } from "./pages/editable-application-page/create-application-page/create-house-page";
import { HousePage } from "./pages/application-page/house-page";
import { EditHousePage } from "./pages/editable-application-page/edit-application-page/edit-house-page";
import { ApartmentsPage } from "./pages/applications-page/apartments-page";
import { ApartmentPage } from "./pages/application-page/apartment-page";
import { CreateApartmentPage } from "./pages/editable-application-page/create-application-page/create-apartment-page";
import { EditApartmentPage } from "./pages/editable-application-page/edit-application-page/edit-apartment-page";

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

          <Route path="/houses">
            <Route path="/houses" element={<HousesPage />} />
            <Route path="/houses/new" element={<CreateHousePage />} />
            <Route path="/houses/:id" element={<HousePage />} />
            <Route path="/houses/:id/edit" element={<EditHousePage />} />
          </Route>

          <Route path="/apartments">
            <Route path="/apartments" element={<ApartmentsPage />} />
            <Route path="/apartments/new" element={<CreateApartmentPage />} />
            <Route path="/apartments/:id" element={<ApartmentPage />} />
            <Route path="/apartments/:id/edit" element={<EditApartmentPage />} />
          </Route>
        </Route>
      </Routes>
    </BrowserRouter>
  );
}
