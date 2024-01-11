import { useState } from "react";
import { useSearchParams } from "react-router-dom";
import { env } from "../env";
import { CardApartment } from "../models/card-apartment";
import { CardApplication } from "../models/card-application";
import { CardHouse } from "../models/card-house";
import { CardLandParcel } from "../models/card-land-parcel";
import { PaginatedApplicationCollection } from "../models/paginated-applications-collection";
import api from "./api";

export function useApplicationsPageState<A extends CardLandParcel | CardApartment | CardHouse>() {
  const [isLoading, setLoading] = useState(true);
  const [applications, setApplications] = useState<CardApplication<A>[]>([]);
  const [lastPage, setLastPage] = useState(1);

  const [params, setParams] = useSearchParams();

  function adjustParams(applicable: "land-parcels" | "houses" | "apartments") {
    setParams((prev) => {
      if (!params.has("types[]", applicable)) {
        prev.delete("types[]");
        prev.set("types[]", applicable);
      }

      if (!params.has("start-date")) {
        prev.set("start-date", `${new Date().getFullYear()}-01-01`);
      }
      return prev;
    });
  }

  function loadApplications() {
    setLoading(true);
    const route = `${env.API_URL}/applications${document.location.search}`;
    api.get<PaginatedApplicationCollection<A>>(route).then(({ data }) => {
      setApplications(data.data);
      setLastPage(data.meta.lastPage);
      setLoading(false);
    });
  }

  return {
    isLoading,
    applications,
    lastPage,
    params,
    setParams,
    loadApplications,
    adjustParams,
  };
}
