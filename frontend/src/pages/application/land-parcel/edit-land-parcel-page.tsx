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
import { Spinner } from "../../../components/spinner/spinner";
import { PhotoForm } from "../../../components/forms/photo-form";
import { useEditablePageState } from "../../../services/use-editable-page-state";

export function EditLandParcelPage() {
  const { id } = useParams<{ id: string }>();
  const errors = usePageErrors(new LandParcelFormErrors());
  const state = useEditablePageState("land-parcels");
  const options = usePageOptions(new LandParcelOptions(), state.applicableRoute);
  const [initialApplication, setInitialApplication] = useState<Application<LandParcel>>();
  const actions = useEditPageActions(errors, state, id as string, initialApplication?.applicable.id as number);
  const [isLoading, setLoading] = useState(true);

  useEffect(() => {
    options.load();
    api.get<Application<LandParcel>>(`${env.API_URL}/applications/${id}`).then(({ data }) => {
      setInitialApplication(data);
      setLoading(false);
    });
  }, []);

  return (
    <div className="editable-application-page">
      {isLoading && <Spinner className="editable-application-page__spinner" />}
      {!isLoading && (
        <>
          <ClientForm initialState={initialApplication?.client} errors={errors.client} />
          <AddressForm
            initialState={initialApplication?.address}
            forApartment={false}
            options={options.address}
            errors={errors.address}
          />
          <LandParcelForm
            initialState={initialApplication?.applicable}
            options={options.applicable}
            errors={errors.applicable}
          />
          <PhotoForm initialState={initialApplication?.photos.map((photo) => photo.id)} />
          <ApplicationForm
            initialState={initialApplication}
            submit={actions.updateApplication}
            options={options.application}
            errors={errors.application}
            actionName="Save"
            isSubmitting={state.isSubmitting}
          />
        </>
      )}
    </div>
  );
}
