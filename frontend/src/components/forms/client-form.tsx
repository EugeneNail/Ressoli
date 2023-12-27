import { Client } from "../../models/client";
import { Field } from "../custom-control/field";
import { FormProps } from "./form-props";
import "./form.sass";

export class ClientFormErrors {
  name: string[] = [];
  lastName: string[] = [];
  phoneNumber: string[] = [];
}

type ClientFormProps = FormProps<ClientFormErrors, Client>;

export function ClientForm({ errors, submit = () => {}, initialState = new Client() }: ClientFormProps) {
  return (
    <form className="form" onSubmit={submit} id="clientForm">
      <h2 className="form__header left">Client</h2>
      <div className="form__input-group">
        <Field
          initialValue={initialState.name}
          label="Name"
          name="name"
          icon="account_box"
          errors={errors.values.name}
          resetError={errors.reset}
        />
        <Field
          initialValue={initialState.lastName}
          label="Last Name"
          name="lastName"
          icon="account_box"
          errors={errors.values.lastName}
          resetError={errors.reset}
        />
        <Field
          initialValue={initialState.phoneNumber}
          label="Phone number"
          name="phoneNumber"
          icon="contact_phone"
          helperText="Use phone numbers like 0-000-000-0000"
          errors={errors.values.phoneNumber}
          resetError={errors.reset}
        />
      </div>
      <div className="form__button-group"></div>
    </form>
  );
}
