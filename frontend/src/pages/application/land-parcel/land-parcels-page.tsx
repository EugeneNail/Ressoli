import { useEffect, useState } from "react";
import "../applications-page.sass";
import { CardApplication } from "../../../models/card-application";
import { CardLandParcel } from "../../../models/card-land-parcel";
import api from "../../../services/api";
import { env } from "../../../env";
import { ApplicationCard } from "../../../components/application-card/application-card";
import { Spinner } from "../../../components/spinner/spinner";
import { Icon } from "../../../components/icon/icon";
import { PaginatedApplicationCollection } from "../../../models/paginated-applications-collection";
import { Link, useSearchParams } from "react-router-dom";
import { Paginator } from "../../../components/paginator/paginator";
import { Filters } from "../../../components/filters/filters";
import "../../../components/button/button.sass";
import Button, { ButtonStyle } from "../../../components/button/button";

export function LandParcelsPage() {
  const [isLoading, setLoading] = useState(true);
  const [applications, setApplications] = useState<CardApplication<CardLandParcel>[]>([]);
  const [lastPage, setLastPage] = useState(1);

  const [params, setParams] = useSearchParams();
  const page = params.get("page") ?? 1;

  useEffect(() => {
    if (!params.has("types[]", "land-parcels")) {
      setParams((prev) => {
        prev.delete("types[]");
        prev.set("types[]", "land-parcels");
        return prev;
      });
    }
    setLoading(true);
    const route = `${env.API_URL}/applications${document.location.search}`;
    api.get<PaginatedApplicationCollection<CardLandParcel>>(route).then(({ data }) => {
      setApplications(data.data);
      setLastPage(data.meta.lastPage);
      setLoading(false);
    });
  }, [params]);

  const [isOpen, setOpen] = useState(true);

  return (
    <div className="applications-page">
      <div className="applications-page__header">
        <h1 className="applications-page__title">Showing {applications.length} applications</h1>
        <Link className="applications-page__header-button button primary" target="_blank" to="new">
          Add application
        </Link>
      </div>
      <Filters params={params} setParams={setParams} className="applications-page__filters" />
      {!isLoading && applications.length !== 0 && (
        <>
          <div className="applications-page__applications">
            {applications.map((application) => (
              <ApplicationCard key={application.id} application={application} />
            ))}
          </div>
        </>
      )}
      {!isLoading && applications.length === 0 && (
        <div className="applications-page__not-found-group">
          <Icon className="applications-page__not-found-icon" name="search_off" />
          <p className="applications-page__not-found-text">No applications found</p>
        </div>
      )}
      {isLoading && <Spinner className="applications-page__spinner" />}
      {applications.length > 0 && (
        <Paginator
          lastPage={lastPage}
          pageRadius={3}
          currentPage={parseFloat(page as string)}
          className="applications-page__paginator"
        />
      )}
    </div>
  );
}
