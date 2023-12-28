import { AddressFormErrors } from "../components/forms/address-form";
import { ApartmentFormErrors } from "../components/forms/apartment-form";
import { ApplicationFormErrors } from "../components/forms/application-form";
import { ClientFormErrors } from "../components/forms/client-form";
import { HouseFormErrors } from "../components/forms/house-form";
import { LandParcelFormErrors } from "../components/forms/land-parcel-form";
import { Errors, useErrors } from "./use-errors";

export type PageErrors<A extends LandParcelFormErrors | HouseFormErrors | ApartmentFormErrors> = {
  client: Errors<ClientFormErrors>;
  address: Errors<AddressFormErrors>;
  applicable: Errors<A>;
  application: Errors<ApplicationFormErrors>;
};

export function usePageErrors<A extends LandParcelFormErrors | HouseFormErrors | ApartmentFormErrors>(
  initialApplicableFormErrors: A
): PageErrors<A> {
  const client = useErrors(new ClientFormErrors());
  const address = useErrors(new AddressFormErrors());
  const applicable = useErrors(initialApplicableFormErrors);
  const application = useErrors(new ApplicationFormErrors());

  return { client, address, applicable, application };
}
