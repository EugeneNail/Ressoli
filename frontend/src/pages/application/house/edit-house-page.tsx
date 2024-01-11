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
import { HouseForm, HouseFormErrors } from "../../../components/forms/house-form";
import { HouseOptions } from "../../../models/house-options";
import { House } from "../../../models/House";
import { Spinner } from "../../../components/spinner/spinner";
import { PhotoForm } from "../../../components/forms/photo-form";
import { useEditablePageState } from "../../../services/use-editable-page-state";

export function EditHousePage() {
  const { id } = useParams<{ id: string }>();
  const errors = usePageErrors(new HouseFormErrors());
  const state = useEditablePageState("houses");
  const options = usePageOptions(new HouseOptions(), state.applicableRoute);
  const [initialApplication, setInitialApplication] = useState<Application<House>>();
  const actions = useEditPageActions(errors, state, id as string, initialApplication?.applicable.id as number);
  const [isLoading, setLoading] = useState(true);

  useEffect(() => {
    options.load();
    api.get<Application<House>>(`${env.API_URL}/applications/${id}`).then(({ data }) => {
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
          <HouseForm
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
