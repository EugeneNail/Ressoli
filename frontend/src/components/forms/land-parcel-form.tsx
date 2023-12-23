import { FormWithOptions } from "../../models/form-with-options";
import { LandParcel } from "../../models/land-parcel";
import { LandParcelOptions } from "../../models/land-parcel-options";
import Button from "../button/button";
import { FormProps } from "./form-props";

export class LandParcelFormErrors {
  water: string[] = [];
  gas: string[] = [];
  electricity: string[] = [];
  sewer: string[] = [];
  area: string[] = [];
}

type LandParcelFormProps = FormProps<LandParcelFormErrors, LandParcel> & FormWithOptions<LandParcelOptions>;

export function LandParcelForm({ submit, errors, options }: LandParcelFormProps) {
  return (
    <form className="form" onSubmit={submit}>
      <div className="form__input-group"></div>
      <div className="form__button-group">
        <Button wide text="Create new application" />
      </div>
    </form>
  );
}
