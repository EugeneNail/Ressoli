import { env } from "../env";
import api from "./api";
import { PageErrors } from "./use-page-errors";
import { HouseFormErrors } from "../components/forms/house-form";
import { LandParcelFormErrors } from "../components/forms/land-parcel-form";
import { useNavigate } from "react-router";
import { ApartmentFormErrors } from "../components/forms/apartment-form";

export function useCreatePageActions<A extends LandParcelFormErrors | HouseFormErrors | ApartmentFormErrors>(
  errors: PageErrors<A>,
  applicableRoute: string
) {
  const navigate = useNavigate();

  async function createClient() {
    const payload = new FormData(document.getElementById("clientForm") as HTMLFormElement);
    const { data, status } = await api.post(`${env.API_URL}/clients`, payload);

    if (status === 422 || status === 409) {
      errors.client.set(data.errors);
      alert("The client is not valid");
      return 0;
    }

    if (status === 201 || status === 200) {
      return data;
    }
  }

  async function createAddress() {
    const payload = new FormData(document.getElementById("addressForm") as HTMLFormElement);
    const { data, status } = await api.post(`${env.API_URL}/addresses`, payload);

    if (status === 422 || status === 409) {
      errors.address.set(data.errors);
      alert("The address is not valid");
      return 0;
    }

    if (status === 201 || status === 200) {
      return data;
    }
  }

  async function createApplicable() {
    const payload = new FormData(document.getElementById("applicableForm") as HTMLFormElement);
    const { data, status } = await api.post(`${env.API_URL}/${applicableRoute}`, payload);

    if (status === 422 || status === 409) {
      errors.applicable.set(data.errors);
      alert("The real estate is not valid");
      return 0;
    }

    if (status === 201) {
      return data;
    }
  }

  async function createNewApplication() {
    const payload = new FormData(document.getElementById("applicationForm") as HTMLFormElement);
    payload.set("clientId", await createClient());
    payload.set("addressId", await createAddress());
    payload.set("applicableId", await createApplicable());
    const { data, status } = await api.post(`${env.API_URL}/applications/${applicableRoute}`, payload);

    if (status === 201) {
      navigate(`/${applicableRoute}/${data}`);
    }

    if (status === 422) {
      errors.application.set(data.errors);
    }
  }

  return { createClient, createAddress, createApplicable, createNewApplication };
}
