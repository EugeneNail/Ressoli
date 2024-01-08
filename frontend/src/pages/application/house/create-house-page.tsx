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

export function CreateHousePage() {
  const applicableRoute = "houses";
  const errors = usePageErrors(new HouseFormErrors());
  const options = usePageOptions(new HouseOptions(), applicableRoute);
  const actions = useCreatePageActions(errors, applicableRoute);

  useEffect(() => {
    options.load();
  }, []);

  return (
    <div className="editable-application-page">
      <ClientForm errors={errors.client} />
      <AddressForm options={options.address} errors={errors.address} />
      <HouseForm options={options.applicable} errors={errors.applicable} />
      <PhotoForm />
      <ApplicationForm
        submit={actions.createNewApplication}
        options={options.application}
        errors={errors.application}
      />
    </div>
  );
}
