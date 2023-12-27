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

export function EditHousePage() {
  const { id } = useParams<{ id: string }>();
  const applicableRoute = "houses";
  const errors = usePageErrors(new HouseFormErrors());
  const options = usePageOptions(new HouseOptions(), applicableRoute);
  const [initialState, setInitialState] = useState<Application<House>>();
  const actions = useEditPageActions(errors, applicableRoute, id as string, initialState?.applicable.id as number);

  useEffect(() => {
    options.load();
    api.get<Application<House>>(`${env.API_URL}/applications/${id}`).then(({ data }) => {
      setInitialState(data);
    });
  }, []);

  return (
    <div className="editable-application-page">
      <ClientForm initialState={initialState?.client} errors={errors.client} />
      <AddressForm initialState={initialState?.address} options={options.address} errors={errors.address} />
      <HouseForm initialState={initialState?.applicable} options={options.applicable} errors={errors.applicable} />
      <ApplicationForm
        initialState={initialState}
        submit={actions.updateApplication}
        options={options.application}
        errors={errors.application}
      />
    </div>
  );
}
