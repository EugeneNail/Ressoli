import { useState } from "react";
import { AddressOptions } from "../models/address-options";
import { ApplicationOptions } from "../models/application-options";
import { HouseOptions } from "../models/house-options";
import { LandParcelOptions } from "../models/land-parcel-options";
import { env } from "../env";
import { ApartmentOptions } from "../models/apartment-options";
import { useHttp } from "./useHttp";

export function usePageOptions<O extends LandParcelOptions | HouseOptions | ApartmentOptions>(
  initialApplicableOptions: O,
  applicableRoute: string
) {
  const http = useHttp();
  const [address, setAddressOptions] = useState(new AddressOptions());
  const [applicable, setApplicableOptions] = useState(initialApplicableOptions);
  const [application, setApplicationOptions] = useState(new ApplicationOptions());

  function load() {
    http.get<AddressOptions>(`${env.API_URL}/options/addresses`).then(({ data }) => setAddressOptions(data));
    http.get<O>(`${env.API_URL}/options/${applicableRoute}`).then(({ data }) => setApplicableOptions(data));
    http.get<ApplicationOptions>(`${env.API_URL}/options/applications`).then(({ data }) => setApplicationOptions(data));
  }

  return { address, applicable, application, load };
}
