import { useEffect } from "react";
import { ClientForm } from "../../../components/forms/client-form";
import { AddressForm } from "../../../components/forms/address-form";
import "../editable-application-page.sass";
import { ApplicationForm } from "../../../components/forms/application-form";
import { usePageErrors } from "../../../services/use-page-errors";
import { usePageOptions } from "../../../services/use-page-options";
import { useCreatePageActions } from "../../../services/use-create-page-actions";
import { ApartmentForm, ApartmentFormErrors } from "../../../components/forms/apartment-form";
import { ApartmentOptions } from "../../../models/apartment-options";
import { PhotoForm } from "../../../components/forms/photo-form";

export function CreateApartmentPage() {
  const applicableRoute = "apartments";
  const errors = usePageErrors(new ApartmentFormErrors());
  const options = usePageOptions(new ApartmentOptions(), applicableRoute);
  const actions = useCreatePageActions(errors, applicableRoute);

  useEffect(() => {
    options.load();
  }, []);

  return (
    <div className="editable-application-page">
      <ClientForm errors={errors.client} />
      <AddressForm forApartment options={options.address} errors={errors.address} />
      <ApartmentForm options={options.applicable} errors={errors.applicable} />
      <PhotoForm />
      <ApplicationForm
        submit={actions.createNewApplication}
        options={options.application}
        errors={errors.application}
      />
    </div>
  );
}
