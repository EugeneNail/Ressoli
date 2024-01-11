import { useParams } from "react-router";
import "../editable-application-page.sass";
import { useState, useEffect } from "react";
import { AddressForm } from "../../../components/forms/address-form";
import { ApplicationForm } from "../../../components/forms/application-form";
import { ClientForm } from "../../../components/forms/client-form";
import { env } from "../../../env";
import api from "../../../services/api";
import { Application } from "../../../models/application";
import { usePageErrors } from "../../../services/use-page-errors";
import { usePageOptions } from "../../../services/use-page-options";
import { useEditPageActions } from "../../../services/use-edit-page-actions";
import { ApartmentForm, ApartmentFormErrors } from "../../../components/forms/apartment-form";
import { ApartmentOptions } from "../../../models/apartment-options";
import { Apartment } from "../../../models/apartment";
import { Spinner } from "../../../components/spinner/spinner";
import { PhotoForm } from "../../../components/forms/photo-form";
import { useEditablePageState } from "../../../services/use-editable-page-state";

export function EditApartmentPage() {
  const { id } = useParams<{ id: string }>();
  const errors = usePageErrors(new ApartmentFormErrors());
  const state = useEditablePageState("apartments");
  const options = usePageOptions(new ApartmentOptions(), state.applicableRoute);
  const [initialState, setInitialState] = useState<Application<Apartment>>();
  const actions = useEditPageActions(errors, state, id as string, initialState?.applicable.id as number);
  const [isLoading, setLoading] = useState(true);

  useEffect(() => {
    options.load();
    api.get<Application<Apartment>>(`${env.API_URL}/applications/${id}`).then(({ data }) => {
      setInitialState(data);
      setLoading(false);
    });
  }, []);

  return (
    <div className="editable-application-page">
      {isLoading && <Spinner className="editable-application-page__spinner" />}
      {!isLoading && (
        <>
          <ClientForm initialState={initialState?.client} errors={errors.client} />
          <AddressForm initialState={initialState?.address} options={options.address} errors={errors.address} />
          <ApartmentForm
            initialState={initialState?.applicable}
            options={options.applicable}
            errors={errors.applicable}
          />
          <PhotoForm initialState={initialState?.photos.map((photo) => photo.id)} />
          <ApplicationForm
            initialState={initialState}
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
