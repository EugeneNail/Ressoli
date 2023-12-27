import { FormEvent } from "react";
import { Application } from "../../models/application";
import { ApplicationOptions } from "../../models/application-options";
import { FormWithOptions } from "../../models/form-with-options";
import Button from "../button/button";
import { Checkbox } from "../custom-control/checkbox";
import { Dropdown } from "../custom-control/dropdown";
import { Numeric } from "../custom-control/numeric";
import { FormProps } from "./form-props";

export class ApplicationFormErrors {
  clientId: string[] = [];
  addressId: string[] = [];
  applicableId: string[] = [];
  contract: string[] = [];
  price: string[] = [];
  hasMortgage: string[] = [];
}

type ApplicationFormProps = FormProps<ApplicationFormErrors, Application<any>> & FormWithOptions<ApplicationOptions>;

export function ApplicationForm({
  errors,
  submit = () => {},
  options,
  initialState = new Application<any>(),
}: ApplicationFormProps) {
  function onSubmit(event: FormEvent) {
    event.preventDefault();
    submit();
  }

  return (
    <form className="form" onSubmit={onSubmit} id="applicationForm">
      <h2 className="form__header left">Application</h2>
      <div className="form__input-group">
        <Dropdown
          label="Contract"
          name="contract"
          icon="description"
          options={options.contract}
          errors={errors.values.contract}
          resetError={errors.reset}
          initialValue={initialState?.contract}
        />
        <Numeric
          initialValue={initialState.price.toString()}
          label="Price"
          name="price"
          icon="payments"
          min={1}
          step={1}
          max={10000000}
          errors={errors.values.price}
          resetError={errors.reset}
        />
        <Checkbox label="Mortgage" name="hasMortgage" checked={initialState.hasMortgage} />
      </div>
      <div className="form__button-group">
        <Button text="Create application" />
      </div>
    </form>
  );
}
