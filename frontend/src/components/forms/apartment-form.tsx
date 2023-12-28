import { Apartment } from "../../models/apartment";
import { ApartmentOptions } from "../../models/apartment-options";
import { FormWithOptions } from "../../models/form-with-options";
import { Checkbox } from "../custom-control/checkbox";
import { Dropdown } from "../custom-control/dropdown";
import { Numeric } from "../custom-control/numeric";
import { FormProps } from "./form-props";

export class ApartmentFormErrors {
  condition: string[] = [];
  walls: string[] = [];
  bath: string[] = [];
  bathroom: string[] = [];
  ceiling: string[] = [];
  level: string[] = [];
  levelCount: string[] = [];
  area: string[] = [];
  roomCount: string[] = [];
}

type ApartmentFormProps = FormProps<ApartmentFormErrors, Apartment> & FormWithOptions<ApartmentOptions>;

export function ApartmentForm({
  errors,
  submit = () => {},
  initialState = new Apartment(),
  options,
}: ApartmentFormProps) {
  return (
    <form className="form" onSubmit={submit} id="applicableForm">
      <h2 className="form__header left">Apartment</h2>
      <div className="form__input-group">
        <Checkbox label="Water" name="hasWater" checked={initialState.hasWater} />
        <Checkbox label="Gas" name="hasGas" checked={initialState.hasGas} />
        <Checkbox label="Electricity" name="hasElectricity" checked={initialState.hasElectricity} />
        <Checkbox label="Sewer" name="hasSewer" checked={initialState.hasSewer} />
      </div>
      <div className="form__input-group">
        <Dropdown
          label="Walls"
          name="walls"
          icon="garage_door"
          options={options.walls}
          errors={errors.values.walls}
          resetError={errors.reset}
          initialValue={initialState?.walls}
        />
        <Dropdown
          label="Condition"
          name="condition"
          icon="home_and_garden"
          options={options.condition}
          errors={errors.values.condition}
          resetError={errors.reset}
          initialValue={initialState?.condition}
        />
        <Numeric
          label="Ceiling"
          name="ceiling"
          icon="height"
          min={1.5}
          step={0.01}
          precision={2}
          max={5}
          errors={errors.values.ceiling}
          resetError={errors.reset}
          initialValue={initialState?.ceiling.toString()}
        />
        <Numeric
          label="Level"
          name="level"
          icon="floor"
          min={1}
          step={1}
          max={100}
          errors={errors.values.level}
          resetError={errors.reset}
          initialValue={initialState?.level.toString()}
        />
        <Numeric
          label="Level count"
          name="levelCount"
          icon="floor"
          min={1}
          step={1}
          max={100}
          errors={errors.values.levelCount}
          resetError={errors.reset}
          initialValue={initialState?.levelCount.toString()}
        />
      </div>
      <div className="form__input-group">
        <Checkbox label="Heating" name="hasHeating" checked={initialState.hasHeating} />
        <Checkbox label="Hot water" name="hasHotWater" checked={initialState.hasHotWater} />
        <Dropdown
          label="Bath"
          name="bath"
          icon="shower"
          options={options.bath}
          errors={errors.values.bath}
          resetError={errors.reset}
          initialValue={initialState?.bath}
        />
        <Dropdown
          label="Bathroom"
          name="bathroom"
          icon="bathroom"
          options={options.bathroom}
          errors={errors.values.bathroom}
          resetError={errors.reset}
          initialValue={initialState?.bathroom}
        />
      </div>
      <div className="form__input-group">
        <Numeric
          label="Area"
          name="area"
          icon="zoom_out_map"
          min={1}
          step={1}
          max={10000}
          errors={errors.values.area}
          resetError={errors.reset}
          initialValue={initialState?.area.toString()}
        />
        <Numeric
          label="Room count"
          name="roomCount"
          icon="king_bed"
          min={1}
          step={1}
          max={100}
          errors={errors.values.roomCount}
          resetError={errors.reset}
          initialValue={initialState?.roomCount.toString()}
        />

        <Checkbox label="Loggia" name="hasLoggia" checked={initialState.hasLoggia} />
        <Checkbox label="Balcony" name="hasBalcony" checked={initialState.hasBalcony} />
        <Checkbox label="Garage" name="hasGarage" checked={initialState.hasGarage} />
      </div>
      <div className="form__input-group">
        <Checkbox label="Garbage chute" name="hasGarbageChute" checked={initialState.hasGarbageChute} />
        <Checkbox label="Elevator" name="hasElevator" checked={initialState.hasElevator} />
        <Checkbox label="Corner" name="isCorner" checked={initialState.isCorner} />
      </div>
      <div className="form__button-group"></div>
    </form>
  );
}
