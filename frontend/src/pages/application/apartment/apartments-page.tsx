import { useState, useEffect } from "react";
import { ApplicationCard } from "../../../components/application-card/application-card";
import { Icon } from "../../../components/icon/icon";
import { Spinner } from "../../../components/spinner/spinner";
import { env } from "../../../env";
import { CardApplication } from "../../../models/card-application";
import "../applications-page.sass";
import api from "../../../services/api";
import { CardApartment } from "../../../models/card-apartment";
import { Paginator } from "../../../components/paginator/paginator";
import { PaginatedApplicationCollection } from "../../../models/paginated-applications-collection";
import { Link, useSearchParams } from "react-router-dom";
import { Filters } from "../../../components/filters/filters";
import "../../../components/button/button.sass";

export function ApartmentsPage() {
  const [isLoading, setLoading] = useState(true);
  const [applications, setApplications] = useState<CardApplication<CardApartment>[]>([]);
  const [lastPage, setLastPage] = useState(1);

  const [params, setParams] = useSearchParams();
  const page = params.get("page") ?? 1;

  useEffect(() => {
    if (!params.has("types[]", "apartments")) {
      setParams((prev) => {
        prev.delete("types[]");
        prev.set("types[]", "apartments");
        return prev;
      });
    }
    setLoading(true);
    const route = `${env.API_URL}/applications${document.location.search}`;
    api.get<PaginatedApplicationCollection<CardApartment>>(route).then(({ data }) => {
      setApplications(data.data);
      setLastPage(data.meta.lastPage);
      setLoading(false);
    });
  }, [params]);

  return (
    <div className="applications-page">
      <div className="applications-page__header">
        <h1 className="applications-page__title">Showing {applications.length} applications</h1>
        <Link className="applications-page__header-button button primary" to="new">
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
