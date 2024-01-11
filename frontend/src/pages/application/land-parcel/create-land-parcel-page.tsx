import { useEffect } from "react";
import { ClientForm } from "../../../components/forms/client-form";
import { AddressForm } from "../../../components/forms/address-form";
import "../editable-application-page.sass";
import { LandParcelOptions } from "../../../models/land-parcel-options";
import { LandParcelForm, LandParcelFormErrors } from "../../../components/forms/land-parcel-form";
import { ApplicationForm } from "../../../components/forms/application-form";
import { usePageErrors } from "../../../services/use-page-errors";
import { usePageOptions } from "../../../services/use-page-options";
import { useCreatePageActions } from "../../../services/use-create-page-actions";
import { PhotoForm } from "../../../components/forms/photo-form";

export function CreateLandParcelPage() {
  const applicableRoute = "land-parcels";
  const errors = usePageErrors(new LandParcelFormErrors());
  const options = usePageOptions(new LandParcelOptions(), applicableRoute);
  const actions = useCreatePageActions(errors, applicableRoute);

  useEffect(() => {
    options.load();
  }, []);

  return (
    <div className="editable-application-page">
      <ClientForm errors={errors.client} />
      <AddressForm forApartment={false} options={options.address} errors={errors.address} />
      <LandParcelForm options={options.applicable} errors={errors.applicable} />
      <PhotoForm />
      <ApplicationForm
        submit={actions.createNewApplication}
        options={options.application}
        errors={errors.application}
      />
    </div>
  );
}
