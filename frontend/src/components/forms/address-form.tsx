import { Address } from "../../models/address";
import { AddressOptions } from "../../models/address-options";
import { FormWithOptions } from "../../models/form-with-options";
import { Dropdown } from "../custom-control/dropdown";
import { Field } from "../custom-control/field";
import { FormProps } from "./form-props";

export class AddressFormErrors {
  number: string[] = [];
  unit: string[] = [];
  typeOfStreet: string[] = [];
  street: string[] = [];
  city: string[] = [];
  postalCode: string[] = [];
}

type AddressFormProps = FormProps<AddressFormErrors, Address> &
  FormWithOptions<AddressOptions> & {
    forApartment?: boolean;
  };

export function AddressForm({
  errors,
  submit = () => {},
  initialState = new Address(),
  options,
  forApartment,
}: AddressFormProps) {
  return (
    <form className="form" onSubmit={submit} id="addressForm">
      <h2 className="form__header left">Address</h2>
      <div className="form__input-group">
        <Field
          initialValue={initialState?.number}
          label="Number"
          name="number"
          icon="house"
          errors={errors.values.number}
          resetError={errors.reset}
        />
        <Field
          initialValue={initialState?.number}
          label={"Unit" + (forApartment ? "" : " (optional)")}
          name="unit"
          icon="apartment"
          errors={errors.values.number}
          resetError={errors.reset}
        />
        <Dropdown
          initialValue={initialState?.typeOfStreet}
          label="Type of street"
          name="typeOfStreet"
          icon="add_road"
          options={options.typeOfStreet}
          errors={errors.values.typeOfStreet}
          resetError={errors.reset}
        />
        <Field
          initialValue={initialState?.street}
          label="Street"
          name="street"
          icon="add_road"
          errors={errors.values.street}
          resetError={errors.reset}
        />
        <Field
          initialValue={initialState?.city}
          label="City"
          name="city"
          icon="map"
          errors={errors.values.city}
          resetError={errors.reset}
        />
        <Field
          initialValue={initialState?.postalCode}
          label="Postal Code (optional)"
          name="postalCode"
          icon="mail"
          errors={errors.values.postalCode}
          resetError={errors.reset}
        />
      </div>
      <div className="form__button-group"></div>
    </form>
  );
}
