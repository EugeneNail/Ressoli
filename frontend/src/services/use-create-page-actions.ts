import { env } from "../env";
import api from "./api";
import { PageErrors } from "./use-page-errors";
import { HouseFormErrors } from "../components/forms/house-form";
import { LandParcelFormErrors } from "../components/forms/land-parcel-form";
import { useNavigate } from "react-router";
import { ApartmentFormErrors } from "../components/forms/apartment-form";
import { EditablePageState } from "./use-editable-page-state";
import { useNotificationContext } from "../components/notifications/notifications";

export function useCreatePageActions<A extends LandParcelFormErrors | HouseFormErrors | ApartmentFormErrors>(
  errors: PageErrors<A>,
  state: EditablePageState
) {
  const navigate = useNavigate();
  const context = useNotificationContext();

  function throwNotification() {
    context.addNotification("The data entered is invalid. Make sure the data is valid and try again.", false);
  }

  async function createClient() {
    const payload = new FormData(document.getElementById("clientForm") as HTMLFormElement);
    const { data, status } = await api.post(`${env.API_URL}/clients`, payload);

    if (status === 422 || status === 409) {
      errors.client.set(data.errors);
      throwNotification();
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
      throwNotification();

      return 0;
    }

    if (status === 201 || status === 200) {
      return data;
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

  async function createApplicable() {
    const payload = new FormData(document.getElementById("applicableForm") as HTMLFormElement);
    const { data, status } = await api.post(`${env.API_URL}/${state.applicableRoute}`, payload);

    if (status === 422 || status === 409) {
      errors.applicable.set(data.errors);
      throwNotification();

      return 0;
    }

    if (status === 201) {
      return data;
    }
  }

  async function createNewApplication() {
    state.setSubmitting(true);
    const payload = new FormData(document.getElementById("applicationForm") as HTMLFormElement);
    payload.set("clientId", await createClient());
    payload.set("addressId", await createAddress());
    addPhotos(payload);
    payload.set("applicableId", await createApplicable());
    const { data, status } = await api.post(`${env.API_URL}/applications/${state.applicableRoute}`, payload);

    if (status === 201) {
      navigate(`/${state.applicableRoute}/${data}`);
    }

    if (status === 422) {
      errors.application.set(data.errors);
      throwNotification();
    }
    state.setSubmitting(false);
  }

  return { createClient, createAddress, createApplicable, createNewApplication };
}
