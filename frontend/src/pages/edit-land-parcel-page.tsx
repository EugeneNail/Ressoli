import { useNavigate, useParams } from "react-router";
import "./editable-application-page.sass";
import { useState, useEffect, FormEvent } from "react";
import { AddressForm, AddressFormErrors } from "../components/forms/address-form";
import { ApplicationForm, ApplicationFormErrors } from "../components/forms/application-form";
import { ClientForm, ClientFormErrors } from "../components/forms/client-form";
import { LandParcelForm, LandParcelFormErrors } from "../components/forms/land-parcel-form";
import { env } from "../env";
import { AddressOptions } from "../models/address-options";
import { ApplicationOptions } from "../models/application-options";
import { LandParcelOptions } from "../models/land-parcel-options";
import api from "../services/api";
import { useErrors } from "../services/use-errors";
import { Application } from "../models/application";
import { LandParcel } from "../models/land-parcel";

export function EditLandParcelPage() {
  const { id } = useParams<{ id: string }>();
  const clientFormErrors = useErrors(new ClientFormErrors());
  const addressFormErrors = useErrors(new AddressFormErrors());
  const applicableFormErrors = useErrors(new LandParcelFormErrors());
  const applicationFormErrors = useErrors(new ApplicationFormErrors());

  const [addressOptions, setAddressOptions] = useState(new AddressOptions());
  const [applicableOptions, setApplicableOptions] = useState(new LandParcelOptions());
  const [applicationOptions, setApplicationOptions] = useState(new ApplicationOptions());

  const applicableRoute = "land-parcels";
  const navigate = useNavigate();

  const [initialState, setInitialState] = useState<Application<LandParcel>>();

  useEffect(() => {
    api.get<AddressOptions>(`${env.API_URL}/options/addresses`).then(({ data }) => setAddressOptions(data));
    api
      .get<LandParcelOptions>(`${env.API_URL}/options/${applicableRoute}`)
      .then(({ data }) => setApplicableOptions(data));

    api.get<ApplicationOptions>(`${env.API_URL}/options/applications`).then(({ data }) => setApplicationOptions(data));
    api.get<Application<LandParcel>>(`${env.API_URL}/applications/${id}`).then(({ data }) => {
      setInitialState(data);
    });
  }, []);

  async function updateClient() {
    const payload = new FormData(document.getElementById("clientForm") as HTMLFormElement);
    const { data, status } = await api.post(`${env.API_URL}/clients`, payload);

    if (status === 422 || status === 409) {
      clientFormErrors.set(data.errors);
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
      addressFormErrors.set(data.errors);
      alert("The address is not valid");
      return 0;
    }

    if (status === 201 || status === 200) {
      return data;
    }
  }

  async function updateApplicable(applicableRoute: string) {
    const payload = new FormData(document.getElementById("applicableForm") as HTMLFormElement);
    const { data, status } = await api.put(`${env.API_URL}/${applicableRoute}/${initialState?.applicable.id}`, payload);

    if (status === 422) {
      applicableFormErrors.set(data.errors);
      alert("The real estate is not valid");
      return 0;
    }

    if (status === 204) {
      return initialState?.applicable.id as any;
    }
  }

  async function updateApplication(event: FormEvent) {
    event.preventDefault();
    const payload = new FormData(event.target as HTMLFormElement);
    payload.set("clientId", await updateClient());
    payload.set("addressId", await updateAddress());
    payload.set("applicableId", await updateApplicable(applicableRoute));
    const { data, status } = await api.put(`${env.API_URL}/applications/${applicableRoute}/${id}`, payload);

    if (status === 204) {
      navigate(`/${applicableRoute}/${id}`);
    }

    if (status === 422) {
      applicationFormErrors.set(data.errors);
    }
  }

  return (
    <div className="editable-application-page">
      <ClientForm initialState={initialState?.client} name="clientForm" errors={clientFormErrors} />
      <AddressForm
        initialState={initialState?.address}
        name="addressForm"
        options={addressOptions}
        errors={addressFormErrors}
      />
      <LandParcelForm
        initialState={initialState?.applicable}
        name="applicableForm"
        options={applicableOptions}
        errors={applicableFormErrors}
      />
      <ApplicationForm
        initialState={initialState}
        submit={updateApplication}
        options={applicationOptions}
        errors={applicationFormErrors}
      />
    </div>
  );
}
