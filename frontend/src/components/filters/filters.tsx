import classNames from "classnames";
import "./filters.sass";
import { Radio } from "../custom-control/radio";
import { Range } from "../custom-control/range";
import { Dispatch, FormEvent, SetStateAction, useEffect, useState } from "react";
import { Checkbox } from "../custom-control/checkbox";
import DatePicker from "react-datepicker";
import "react-datepicker/dist/react-datepicker.css";
import { Format } from "../../services/format";
import Button from "../button/button";
import "../custom-control/custom-control.sass";
import { Icon } from "../icon/icon";

type FiltersProps = {
  className?: string;
  params: URLSearchParams;
  setParams: Dispatch<SetStateAction<URLSearchParams>>;
};

export function Filters({ className, params, setParams }: FiltersProps) {
  const [isOpen, setOpen] = useState(false);

  const [contract, setContract] = useState("");
  const [status, setStatus] = useState("");
  const [owned] = useState(false);
  const [noPhotos] = useState(false);

  const [startPrice, setStartPrice] = useState(0);
  const [endPrice, setEndPrice] = useState(0);

  const [startArea, setStartArea] = useState(0);
  const [endArea, setEndArea] = useState(0);

  const [startDate, setStartDate] = useState(new Date());
  const [endDate, setEndDate] = useState(new Date());

  useEffect(() => {
    setContract(params.get("contract") ?? "All");
    setStatus(params.get("status") ?? "All");
    setStartPrice(+(params.get("start-price") ?? 1));
    setEndPrice(+(params.get("end-price") ?? 10000000));
    setStartArea(+(params.get("start-area") ?? 1));
    setEndArea(+(params.get("end-area") ?? 10000));
    setStartDate(new Date(params.get("start-date") ?? new Date(`${new Date().getFullYear()}-01-01`)));
    setEndDate(new Date(params.get("end-date") ?? new Date()));
  }, [params]);

  function applyFilters(event: FormEvent) {
    event.preventDefault();
    const data = new FormData(event.target as HTMLFormElement);
    const owned = data.get("owned");
    const noPhotos = data.get("noPhotos");

    setParams((prev) => {
      contract === "All" ? prev.delete("contract") : prev.set("contract", contract);
      status === "All" ? prev.delete("status") : prev.set("status", status);
      startPrice <= 1 ? prev.delete("start-price") : prev.set("start-price", startPrice.toString());
      endPrice >= 5000000 ? prev.delete("end-price") : prev.set("end-price", endPrice.toString());
      startArea <= 1 ? prev.delete("start-area") : prev.set("start-area", startArea.toString());
      endArea >= 1000 ? prev.delete("end-area") : prev.set("end-area", endArea.toString());
      startDate === new Date("2000-01-01")
        ? prev.delete("start-date")
        : prev.set("start-date", Format.toShortDate(startDate));
      endDate === new Date("2099-12-31") ? prev.delete("end-date") : prev.set("end-date", Format.toShortDate(endDate));
      owned ? prev.set("owned", "true") : prev.delete("owned");
      noPhotos ? prev.set("no-photos", "true") : prev.delete("no-photos");
      prev.set("page", "1");
      return prev;
    });
    setOpen(false);
  }

  function setStartRange(
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

  function setEndRange(
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
    <form
      className={classNames("filters", className)}
      onSubmit={(e) => applyFilters(e)}
      style={{ height: isOpen ? "fit-content" : "6.4rem" }}
    >
      <div className="filters__spoiler" onClick={() => setOpen(!isOpen)}>
        <h2 className="filters__header">Filters</h2>
        <Icon
          className="filters__spoiler-icon"
          name={isOpen ? "keyboard_arrow_up" : "keyboard_arrow_down"}
          onClick={() => setOpen(!isOpen)}
        />
      </div>

      <div className="filters__group">
        <Radio options={["All", "Sale", "Rent"]} onChange={setContract} selected={contract} />
        <Radio options={["All", "Active", "Archived"]} onChange={setStatus} selected={status} />
        <div className="filters__info">
          <h5 className="filters__label">Date</h5>
          <p className="filter__subtext">from</p>
          <DatePicker
            dateFormat="yyyy-MM-dd"
            selected={startDate}
            selectsStart
            showMonthDropdown
            showYearDropdown
            onChange={(date: Date) => {
              if (date > endDate) {
                setEndDate(date);
              }
              setStartDate(date);
            }}
            minDate={new Date("2000-01-01")}
            maxDate={new Date("2099-12-31")}
            startDate={startDate}
            endDate={endDate}
          />
          <p className="filter__subtext">to</p>
          <DatePicker
            dateFormat="yyyy-MM-dd"
            selected={endDate}
            selectsEnd
            showMonthDropdown
            showYearDropdown
            onChange={(date: Date) => {
              if (date < startDate) {
                setStartDate(date);
              }
              setEndDate(date);
            }}
            minDate={new Date("2000-01-01")}
            maxDate={new Date("2099-12-31")}
            startDate={startDate}
            endDate={endDate}
          />
        </div>
      </div>
      <div className="filters__group">
        <div className="filters__info">
          <h5 className="filters__label">Price</h5>
          <p className="filter__subtext">from</p>
          <input
            className="filters__value price"
            value={startPrice === 0 ? "" : startPrice}
            type="number"
            onChange={(e) => setStartRange(+e.target.value, setStartPrice, endPrice, setEndPrice, 10000000)}
          />
          <p className="filter__subtext">to</p>
          <input
            className="filters__value price"
            value={endPrice === 0 ? "" : endPrice}
            type="number"
            onChange={(e) => setEndRange(+e.target.value, setEndPrice, startPrice, setStartPrice, 10000000)}
          />
        </div>
        <Range
          className="filters__range"
          min={1}
          max={5000000}
          step={1}
          startValue={startPrice}
          endValue={endPrice}
          updateStart={setStartPrice}
          updateEnd={setEndPrice}
        />
      </div>
      <div className="filters__group">
        <div className="filters__info">
          <h5 className="filters__label">Area</h5>
          <p className="filter__subtext">from</p>
          <input
            className="filters__value area"
            value={startArea === 0 ? "" : startArea}
            type="number"
            onChange={(e) => setStartRange(+e.target.value, setStartArea, endArea, setEndArea, 10000)}
          />
          <p className="filter__subtext">to</p>
          <div className="filters__test">
            <input
              className="filters__value area"
              value={endArea === 0 ? "" : endArea}
              type="number"
              onChange={(e) => setEndRange(+e.target.value, setEndArea, startArea, setStartArea, 10000)}
            />
          </div>
        </div>
        <Range
          className="filters__range"
          min={1}
          max={500}
          step={1}
          startValue={startArea}
          endValue={endArea}
          updateStart={setStartArea}
          updateEnd={setEndArea}
        />
      </div>
      <div className="filters__group">
        <Checkbox label="My applications" name="owned" checked={owned} />
        <Checkbox label="Without photos" name="noPhotos" checked={noPhotos} />
      </div>
      <Button className="filters__button" text="Apply" />
    </form>
  );
}
