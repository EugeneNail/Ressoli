import { House } from "../../models/House";
import { FormWithOptions } from "../../models/form-with-options";
import { HouseOptions } from "../../models/house-options";
import { Checkbox } from "../custom-control/checkbox";
import { Dropdown } from "../custom-control/dropdown";
import { Numeric } from "../custom-control/numeric";
import { FormProps } from "./form-props";

export class HouseFormErrors {
  water: string[] = [];
  gas: string[] = [];
  electricity: string[] = [];
  sewer: string[] = [];
  walls: string[] = [];
  condition: string[] = [];
  roof: string[] = [];
  floor: string[] = [];
  levelCount: string[] = [];
  hasGarage: string[] = [];
  hotWater: string[] = [];
  heating: string[] = [];
  bath: string[] = [];
  bathroom: string[] = [];
  roomCount: string[] = [];
  area: string[] = [];
  kitchenArea: string[] = [];
  landArea: string[] = [];
}

type HouseFormProps = FormProps<HouseFormErrors, House> & FormWithOptions<HouseOptions>;

export function HouseForm({ errors, submit = () => {}, initialState = new House(), options }: HouseFormProps) {
  return (
    <form className="form" onSubmit={submit} id="applicableForm">
      <h2 className="form__header left">House</h2>
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
          initialValue={initialState?.area?.toString()}
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
        <Numeric
          label="Kitchen area"
          name="kitchenArea"
          icon="kitchen"
          min={1}
          step={1}
          max={10000}
          errors={errors.values.kitchenArea}
          resetError={errors.reset}
          initialValue={initialState?.kitchenArea.toString()}
        />
        <Numeric
          label="Land area"
          name="landArea"
          icon="outdoor_garden"
          min={1}
          step={1}
          max={10000}
          errors={errors.values.landArea}
          resetError={errors.reset}
          initialValue={initialState?.landArea.toString()}
        />
      </div>
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
        <Dropdown
          label="Roof"
          name="roof"
          icon="roofing"
          options={options.roof}
          errors={errors.values.roof}
          resetError={errors.reset}
          initialValue={initialState?.roof}
        />
        <Dropdown
          label="Floor"
          name="floor"
          icon="foundation"
          options={options.floor}
          errors={errors.values.floor}
          resetError={errors.reset}
          initialValue={initialState?.floor}
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
        <Checkbox label="Garage" name="hasGarage" checked={initialState.hasGarage} />
      </div>

      <div className="form__input-group">
        <Dropdown
          label="Hot water"
          name="hotWater"
          icon="water_heater"
          options={options.hotWater}
          errors={errors.values.hotWater}
          resetError={errors.reset}
          initialValue={initialState?.hotWater}
        />
        <Dropdown
          label="Heating"
          name="heating"
          icon="heat"
          options={options.heating}
          errors={errors.values.heating}
          resetError={errors.reset}
          initialValue={initialState?.heating}
        />
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
    </form>
  );
}
