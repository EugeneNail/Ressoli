import { useParams } from "react-router";
import "../editable-application-page.sass";
import { useState, useEffect } from "react";
import { AddressForm } from "../../../components/forms/address-form";
import { ApplicationForm } from "../../../components/forms/application-form";
import { ClientForm } from "../../../components/forms/client-form";
import { LandParcelForm, LandParcelFormErrors } from "../../../components/forms/land-parcel-form";
import { env } from "../../../env";
import { LandParcelOptions } from "../../../models/land-parcel-options";
import api from "../../../services/api";
import { Application } from "../../../models/application";
import { LandParcel } from "../../../models/land-parcel";
import { usePageErrors } from "../../../services/use-page-errors";
import { usePageOptions } from "../../../services/use-page-options";
import { useEditPageActions } from "../../../services/use-edit-page-actions";

export function EditLandParcelPage() {
  const { id } = useParams<{ id: string }>();
  const applicableRoute = "land-parcels";
  const errors = usePageErrors(new LandParcelFormErrors());
  const options = usePageOptions(new LandParcelOptions(), applicableRoute);
  const [initialState, setInitialState] = useState<Application<LandParcel>>();
  const actions = useEditPageActions(errors, applicableRoute, id as string, initialState?.applicable.id as number);

  useEffect(() => {
    options.load();
    api.get<Application<LandParcel>>(`${env.API_URL}/applications/${id}`).then(({ data }) => {
      setInitialState(data);
    });
  }, []);

  return (
    <div className="editable-application-page">
      <ClientForm initialState={initialState?.client} errors={errors.client} />
      <AddressForm initialState={initialState?.address} options={options.address} errors={errors.address} />
      <LandParcelForm initialState={initialState?.applicable} options={options.applicable} errors={errors.applicable} />
      <ApplicationForm
        initialState={initialState}
        submit={actions.updateApplication}
        options={options.application}
        errors={errors.application}
      />
    </div>
  );
}