import { FormWithOptions } from "../../models/form-with-options";
import { LandParcel } from "../../models/land-parcel";
import { LandParcelOptions } from "../../models/land-parcel-options";
import { Dropdown } from "../custom-control/dropdown";
import { Numeric } from "../custom-control/numeric";
import { FormProps } from "./form-props";

export class LandParcelFormErrors {
  water: string[] = [];
  gas: string[] = [];
  electricity: string[] = [];
  sewer: string[] = [];
  area: string[] = [];
}

type LandParcelFormProps = FormProps<LandParcelFormErrors, LandParcel> & FormWithOptions<LandParcelOptions>;

export function LandParcelForm({
  errors,
  submit = () => {},
  initialState = new LandParcel(),
  options,
}: LandParcelFormProps) {
  return (
    <form className="form" onSubmit={submit} id="applicableForm">
      <h2 className="form__header left">Land Parcel</h2>
      <div className="form__input-group">
        <Dropdown
          label="Water"
          name="water"
          icon="water_drop"
          options={options.water}
          errors={errors.values.water}
          resetError={errors.reset}
          initialValue={initialState?.water}
        />
        <Dropdown
          label="Gas"
          name="gas"
          icon="local_fire_department"
          options={options.gas}
          errors={errors.values.gas}
          resetError={errors.reset}
          initialValue={initialState?.gas}
        />
        <Dropdown
          label="Electicity"
          name="electricity"
          icon="flash_on"
          options={options.electricity}
          errors={errors.values.electricity}
          resetError={errors.reset}
          initialValue={initialState?.electricity}
        />
        <Dropdown
          label="Sewer"
          name="sewer"
          icon="water_pump"
          options={options.sewer}
          errors={errors.values.sewer}
          resetError={errors.reset}
          initialValue={initialState?.sewer}
        />
        <Numeric
          label="Area"
          name="area"
          icon="zoom_out_map"
          min={1}
          step={1}
          max={10000}
          errors={errors.values.area}
          resetError={errors.reset}
          initialValue={initialState?.area?.toString()}
        />
      </div>
    </form>
  );
}
