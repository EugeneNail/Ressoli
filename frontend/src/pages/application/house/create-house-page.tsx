import { useEffect } from "react";
import { ClientForm } from "../../../components/forms/client-form";
import { AddressForm } from "../../../components/forms/address-form";
import "../editable-application-page.sass";
import { ApplicationForm } from "../../../components/forms/application-form";
import { HouseOptions } from "../../../models/house-options";
import { HouseForm, HouseFormErrors } from "../../../components/forms/house-form";
import { usePageErrors } from "../../../services/use-page-errors";
import { usePageOptions } from "../../../services/use-page-options";
import { useCreatePageActions } from "../../../services/use-create-page-actions";
import { PhotoForm } from "../../../components/forms/photo-form";
import { useEditablePageState } from "../../../services/use-editable-page-state";

export function CreateHousePage() {
  const errors = usePageErrors(new HouseFormErrors());
  const state = useEditablePageState("houses");
  const options = usePageOptions(new HouseOptions(), state.applicableRoute);
  const actions = useCreatePageActions(errors, state);

  useEffect(() => {
    options.load();
  }, []);

  return (
    <div className="editable-application-page">
      <ClientForm errors={errors.client} />
      <AddressForm options={options.address} errors={errors.address} forApartment={false} />
      <HouseForm options={options.applicable} errors={errors.applicable} />
      <PhotoForm />
      <ApplicationForm
        submit={actions.createNewApplication}
        options={options.application}
        errors={errors.application}
        actionName="Create application"
        isSubmitting={state.isSubmitting}
      />
    </div>
  );
}
