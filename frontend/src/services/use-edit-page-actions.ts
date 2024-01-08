import { ApartmentFormErrors } from "../components/forms/apartment-form";
import { HouseFormErrors } from "../components/forms/house-form";
import { LandParcelFormErrors } from "../components/forms/land-parcel-form";
import { env } from "../env";
import api from "./api";
import { PageErrors } from "./use-page-errors";
import { useNavigate } from "react-router";

export function useEditPageActions<A extends LandParcelFormErrors | HouseFormErrors | ApartmentFormErrors>(
  errors: PageErrors<A>,
  applicableRoute: string,
  applicationId: string,
  applicableId: number
) {
  const navigate = useNavigate();

  async function updateClient() {
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

  async function updateAddress() {
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

  async function updateApplicable() {
    const payload = new FormData(document.getElementById("applicableForm") as HTMLFormElement);
    const { data, status } = await api.put(`${env.API_URL}/${applicableRoute}/${applicableId}`, payload);

    if (status === 422) {
      errors.applicable.set(data.errors);
      alert("The real estate is not valid");
      return 0;
    }

    if (status === 204) {
      return applicableId as any;
    }
  }

  function addPhotos(payload: FormData): void {
    const data = new FormData(document.getElementById("photoForm") as HTMLFormElement);
    Array.from(data.entries())
      .filter((entry) => entry[0] === "photos[]")
      .forEach((entry) => {
        payload.append("photos[]", entry[1]);
      });
  }

  async function updateApplication() {
    const payload = new FormData(document.getElementById("applicationForm") as HTMLFormElement);
    payload.set("clientId", await updateClient());
    payload.set("addressId", await updateAddress());
    addPhotos(payload);
    payload.set("applicableId", await updateApplicable());
    const { data, status } = await api.put(`${env.API_URL}/applications/${applicableRoute}/${applicationId}`, payload);

    if (status === 204) {
      navigate(`/${applicableRoute}/${applicationId}`);
    }

    if (status === 422) {
      errors.application.set(data.errors);
    }
  }

  return { updateClient, updateAddress, updateApplicable, updateApplication };
}
