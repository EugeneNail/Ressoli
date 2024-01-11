import classNames from "classnames";
import "./filters.sass";
import { Radio } from "../custom-control/radio";
import { Range } from "../custom-control/range";
import { Dispatch, FormEvent, SetStateAction, useState } from "react";
import { Checkbox } from "../custom-control/checkbox";
import DatePicker from "react-datepicker";
import "react-datepicker/dist/react-datepicker.css";
import { Format } from "../../services/format";
import Button from "../button/button";
import "../custom-control/custom-control.sass";
import { useNavigate, useSearchParams } from "react-router-dom";
import { Icon } from "../icon/icon";

type FiltersProps = {
  className?: string;
};

export function Filters({ className }: FiltersProps) {
  const [params, setParams] = useSearchParams(new URLSearchParams(document.location.search));
  const [contract, setContract] = useState(params.get("contract") ?? "All");
  const [status, setStatus] = useState(params.get("status") ?? "All");
  const [minPrice, setMinPrice] = useState(+(params.get("min-price") ?? 1));
  const [minArea, setMinArea] = useState(+(params.get("min-area") ?? 1));
  const [maxPrice, setMaxPrice] = useState(+(params.get("max-price") ?? 10000000));
  const [maxArea, setMaxArea] = useState(+(params.get("max-area") ?? 10000));
  const [minDate, setMinDate] = useState(new Date(params.get("min-date") ?? new Date("2000-01-01")));
  const [maxDate, setMaxDate] = useState(new Date(params.get("max-date") ?? new Date()));
  const [owned] = useState(params.get("owned") === "true");
  const [noPhotos] = useState(params.get("no-photos") === "true");
  const [isOpen, setOpen] = useState(false);

  function applyFilters(event: FormEvent) {
    event.preventDefault();
    const data = new FormData(event.target as HTMLFormElement);
    const owned = data.get("owned");
    const noPhotos = data.get("noPhotos");

    setParams((prev) => {
      contract === "All" ? prev.delete("contract") : prev.set("contract", contract);
      status === "All" ? prev.delete("status") : prev.set("status", status);
      minPrice <= 1 ? prev.delete("min-price") : prev.set("min-price", minPrice.toString());
      maxPrice >= 5000000 ? prev.delete("max-price") : prev.set("max-price", maxPrice.toString());
      minArea <= 1 ? prev.delete("min-area") : prev.set("min-area", minArea.toString());
      maxArea >= 1000 ? prev.delete("max-area") : prev.set("max-area", maxArea.toString());
      minDate === new Date("2000-01-01") ? prev.delete("min-date") : prev.set("min-date", Format.toShortDate(minDate));
      maxDate === new Date("2099-12-31") ? prev.delete("max-date") : prev.set("max-date", Format.toShortDate(maxDate));
      owned ? prev.set("owned", "true") : prev.delete("owned");
      noPhotos ? prev.set("no-photos", "true") : prev.delete("no-photos");
      prev.set("page", "1");
      return prev;
    });
    window.location.replace(`${window.location.pathname}?${params}`);
  }

  function setMinRange(
    value: number,
    set: Dispatch<SetStateAction<number>>,
    opposite: number,
    setOpposite: Dispatch<SetStateAction<number>>,
    max: number
  ) {
    if (value >= max) {
      set(max);
      setOpposite(max);
      return;
    }
    if (value >= opposite) {
      setOpposite(value);
    }
    if (value <= 0) {
      set(0);
      return;
    }
    set(value);
  }

  function setMaxRange(
    value: number,
    set: Dispatch<SetStateAction<number>>,
    opposite: number,
    setOpposite: Dispatch<SetStateAction<number>>,
    max: number
  ) {
    if (value >= max) {
      set(max);
      return;
    }
    if (value <= opposite) {
      setOpposite(value);
    }
    if (value <= 0 && opposite !== 0) {
      set(0);
      return;
    }
    set(value);
  }

  return (
    <form className={classNames("filters", className)} onSubmit={(e) => applyFilters(e)}>
      <div className="filters__spoiler" onClick={() => setOpen(!isOpen)}>
        <h2 className="filters__header">Filters</h2>
        <Icon
          className="filters__spoiler-icon"
          name={isOpen ? "keyboard_arrow_up" : "keyboard_arrow_down"}
          onClick={() => setOpen(!isOpen)}
        />
      </div>
      {isOpen && (
        <>
          <div className="filters__group">
            <Radio options={["All", "Sale", "Rent"]} onChange={setContract} selected={contract} />
            <Radio options={["All", "Active", "Archived"]} onChange={setStatus} selected={status} />
            <div className="filters__info">
              <h5 className="filters__label">Date</h5>
              <p className="filter__subtext">from</p>
              <DatePicker
                dateFormat="yyyy-MM-dd"
                selected={minDate}
                selectsStart
                showMonthDropdown
                showYearDropdown
                onChange={(date: Date) => {
                  if (date > maxDate) {
                    setMaxDate(date);
                  }
                  setMinDate(date);
                }}
                minDate={new Date("2000-01-01")}
                maxDate={new Date("2099-12-31")}
                startDate={minDate}
                endDate={maxDate}
              />
              <p className="filter__subtext">to</p>
              <DatePicker
                dateFormat="yyyy-MM-dd"
                selected={maxDate}
                selectsEnd
                showMonthDropdown
                showYearDropdown
                onChange={(date: Date) => {
                  if (date < minDate) {
                    setMinDate(date);
                  }
                  setMaxDate(date);
                }}
                minDate={new Date("2000-01-01")}
                maxDate={new Date("2099-12-31")}
                startDate={minDate}
                endDate={maxDate}
              />
            </div>
          </div>
          <div className="filters__group">
            <div className="filters__info">
              <h5 className="filters__label">Price</h5>
              <p className="filter__subtext">from</p>
              <input
                className="filters__value"
                value={minPrice === 0 ? "" : minPrice}
                type="number"
                onChange={(e) => setMinRange(+e.target.value, setMinPrice, maxPrice, setMaxPrice, 10000000)}
              />
              <p className="filter__subtext">to</p>
              <input
                className="filters__value"
                value={maxPrice === 0 ? "" : maxPrice}
                type="number"
                onChange={(e) => setMaxRange(+e.target.value, setMaxPrice, minPrice, setMinPrice, 10000000)}
              />
            </div>
            <Range
              className="filters__range"
              min={1}
              max={5000000}
              step={1}
              leftValue={minPrice}
              rightValue={maxPrice}
              onChangeLeft={setMinPrice}
              onChangeRight={setMaxPrice}
            />
          </div>
          <div className="filters__group">
            <div className="filters__info">
              <h5 className="filters__label">Area</h5>
              <p className="filter__subtext">from</p>
              <input
                className="filters__value"
                value={minArea === 0 ? "" : minArea}
                type="number"
                onChange={(e) => setMinRange(+e.target.value, setMinArea, maxArea, setMaxArea, 10000)}
              />
              <p className="filter__subtext">to</p>
              <input
                className="filters__value"
                value={maxArea === 0 ? "" : maxArea}
                type="number"
                onChange={(e) => setMaxRange(+e.target.value, setMaxArea, minArea, setMinArea, 10000)}
              />
            </div>
            <Range
              className="filters__range"
              min={1}
              max={1000}
              step={1}
              leftValue={minArea}
              rightValue={maxArea}
              onChangeLeft={setMinArea}
              onChangeRight={setMaxArea}
            />
          </div>
          <div className="filters__group">
            <Checkbox label="My applications" name="owned" checked={owned} />
            <Checkbox label="Without photos" name="noPhotos" checked={noPhotos} />
          </div>
          <Button className="filters__button" text="Apply" />
        </>
      )}
    </form>
  );
}
