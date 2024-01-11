import { useEffect } from "react";
import "../applications-page.sass";
import { CardLandParcel } from "../../../models/card-land-parcel";
import { ApplicationCard } from "../../../components/application-card/application-card";
import { Spinner } from "../../../components/spinner/spinner";
import { Icon } from "../../../components/icon/icon";
import { Link } from "react-router-dom";
import { Paginator } from "../../../components/paginator/paginator";
import { Filters } from "../../../components/filters/filters";
import "../../../components/button/button.sass";
import { useApplicationsPageState } from "../../../services/use-applications-page-state";

export function LandParcelsPage() {
  const { isLoading, lastPage, adjustParams, applications, loadApplications, params, setParams } =
    useApplicationsPageState<CardLandParcel>();

  useEffect(() => {
    adjustParams("land-parcels");
    loadApplications();
  }, [params]);

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
          currentPage={+(params.get("page") ?? 1)}
          className="applications-page__paginator"
        />
      )}
    </div>
  );
}
