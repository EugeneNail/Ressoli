import { ApartmentFormErrors } from "../components/forms/apartment-form";
import { HouseFormErrors } from "../components/forms/house-form";
import { LandParcelFormErrors } from "../components/forms/land-parcel-form";
import { useNotificationContext } from "../components/notifications/notifications";
import { env } from "../env";
import { EditablePageState } from "./use-editable-page-state";
import { PageErrors } from "./use-page-errors";
import { useNavigate } from "react-router";
import { useHttp } from "./useHttp";

export function useEditPageActions<A extends LandParcelFormErrors | HouseFormErrors | ApartmentFormErrors>(
  errors: PageErrors<A>,
  state: EditablePageState,
  applicationId: string,
  applicableId: number
) {
  const http = useHttp();
  const navigate = useNavigate();
  const context = useNotificationContext();

  function throwNotification() {
    context.addNotification("The data entered is invalid. Make sure the data is valid and try again.", false);
  }

  async function updateClient() {
    const payload = new FormData(document.getElementById("clientForm") as HTMLFormElement);
    const { data, status } = await http.post(`${env.API_URL}/clients`, payload);

    if (status === 422 || status === 409) {
      errors.client.set(data.errors);
      throwNotification();

      return 0;
    }

    if (status === 201 || status === 200) {
      return data;
    }
  }

  async function updateAddress() {
    const payload = new FormData(document.getElementById("addressForm") as HTMLFormElement);
    const { data, status } = await http.post(`${env.API_URL}/addresses`, payload);

    if (status === 422 || status === 409) {
      errors.address.set(data.errors);
      throwNotification();

      return 0;
    }

    if (status === 201 || status === 200) {
      return data;
    }
  }

  async function updateApplicable() {
    const payload = new FormData(document.getElementById("applicableForm") as HTMLFormElement);
    const { data, status } = await http.put(`${env.API_URL}/${state.applicableRoute}/${applicableId}`, payload);

    if (status === 422) {
      errors.applicable.set(data.errors);
      throwNotification();

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
    state.setSubmitting(true);
    const payload = new FormData(document.getElementById("applicationForm") as HTMLFormElement);
    payload.set("clientId", await updateClient());
    payload.set("addressId", await updateAddress());
    addPhotos(payload);
    payload.set("applicableId", await updateApplicable());
    const { data, status } = await http.put(
      `${env.API_URL}/applications/${state.applicableRoute}/${applicationId}`,
      payload
    );

    if (status === 204) {
      navigate(`/${state.applicableRoute}/${applicationId}`);
    }

    if (status === 422) {
      errors.application.set(data.errors);
      throwNotification();
    }

    state.setSubmitting(false);
  }

  return { updateClient, updateAddress, updateApplicable, updateApplication };
}
