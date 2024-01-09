import { useState, useEffect } from "react";
import { ApplicationCard } from "../../../components/application-card/application-card";
import Button from "../../../components/button/button";
import { Icon } from "../../../components/icon/icon";
import { Spinner } from "../../../components/spinner/spinner";
import { env } from "../../../env";
import { CardApplication } from "../../../models/card-application";
import "../applications-page.sass";
import api from "../../../services/api";
import { CardApartment } from "../../../models/card-apartment";
import { Paginator } from "../../../components/paginator/paginator";
import { PaginatedApplicationCollection } from "../../../models/paginated-applications-collection";
import { useSearchParams } from "react-router-dom";

export function ApartmentsPage() {
  const [isLoading, setLoading] = useState(true);
  const [applications, setApplications] = useState<CardApplication<CardApartment>[]>([]);
  const [lastPage, setLastPage] = useState(1);

  const [params] = useSearchParams();
  const page = params.get("page") ?? 1;

  useEffect(() => {
    setLoading(true);
    const route = `${env.API_URL}/applications${document.location.search}`;
    api.get<PaginatedApplicationCollection<CardApartment>>(route).then(({ data }) => {
      setApplications(data.data);
      setLastPage(data.meta.lastPage);
      setLoading(false);
    });
  }, [page]);

  return (
    <div className="applications-page">
      <div className="applications-page__header">
        <h1 className="applications-page__title">Found {applications.length} applications</h1>
        <Button className="applications-page__header-button" to="new" text="Add application" />
      </div>
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
