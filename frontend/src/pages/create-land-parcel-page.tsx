import { FormEvent, useEffect, useState } from "react";
import { ClientForm, ClientFormErrors } from "../components/forms/client-form";
import { useErrors } from "../services/use-errors";
import { AddressForm, AddressFormErrors } from "../components/forms/address-form";
import { AddressOptions } from "../models/address-options";
import "./editable-application-page.sass";
import { LandParcelOptions } from "../models/land-parcel-options";
import { ApplicationOptions } from "../models/application-options";
import { LandParcelForm, LandParcelFormErrors } from "../components/forms/land-parcel-form";
import { ApplicationForm, ApplicationFormErrors } from "../components/forms/application-form";
import api from "../services/api";
import { env } from "../env";
import { useNavigate } from "react-router";

export function CreateLandParcelPage() {
  const clientFormErrors = useErrors(new ClientFormErrors());
  const addressFormErrors = useErrors(new AddressFormErrors());
  const applicableFormErrors = useErrors(new LandParcelFormErrors());
  const applicationFormErrors = useErrors(new ApplicationFormErrors());

  const [addressOptions, setAddressOptions] = useState(new AddressOptions());
  const [applicableOptions, setApplicableOptions] = useState(new LandParcelOptions());
  const [applicationOptions, setApplicationOptions] = useState(new ApplicationOptions());

  const applicableRoute = "land-parcels";
  const navigate = useNavigate();

  useEffect(() => {
    api.get<AddressOptions>(`${env.API_URL}/options/addresses`).then(({ data }) => setAddressOptions(data));
    api
      .get<LandParcelOptions>(`${env.API_URL}/options/${applicableRoute}`)
      .then(({ data }) => setApplicableOptions(data));

    api.get<ApplicationOptions>(`${env.API_URL}/options/applications`).then(({ data }) => setApplicationOptions(data));
  }, []);

  async function createClient() {
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

  async function createAddress() {
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

  async function createApplicable(applicableRoute: string) {
    const payload = new FormData(document.getElementById("applicableForm") as HTMLFormElement);
    const { data, status } = await api.post(`${env.API_URL}/${applicableRoute}`, payload);

    if (status === 422 || status === 409) {
      applicableFormErrors.set(data.errors);
      alert("The real estate is not valid");
      return 0;
    }

    if (status === 201) {
      return data;
    }
  }

  async function createNewApplication(event: FormEvent) {
    event.preventDefault();
    const payload = new FormData(event.target as HTMLFormElement);
    payload.set("clientId", await createClient());
    payload.set("addressId", await createAddress());
    payload.set("applicableId", await createApplicable(applicableRoute));
    const { data, status } = await api.post(`${env.API_URL}/applications/${applicableRoute}`, payload);

    if (status === 201) {
      navigate(`/${applicableRoute}/${data}`);
    }
  }

  return (
    <div className="editable-application-page">
      <ClientForm name="clientForm" errors={clientFormErrors} />
      <AddressForm name="addressForm" options={addressOptions} errors={addressFormErrors} />
      <LandParcelForm name="applicableForm" options={applicableOptions} errors={applicableFormErrors} />
      <ApplicationForm submit={createNewApplication} options={applicationOptions} errors={applicationFormErrors} />
    </div>
  );
}
