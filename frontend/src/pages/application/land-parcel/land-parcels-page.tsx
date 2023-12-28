import { useEffect, useState } from "react";
import "../applications-page.sass";
import { CardApplication } from "../../../models/card-application";
import { CardLandParcel } from "../../../models/card-land-parcel";
import api from "../../../services/api";
import { env } from "../../../env";
import { ApplicationCard } from "../../../components/application-card/application-card";
import Button from "../../../components/button/button";
import { Spinner } from "../../../components/spinner/spinner";
import { Icon } from "../../../components/icon/icon";

export function LandParcelsPage() {
  const [isLoading, setLoading] = useState(true);
  const [applications, setApplications] = useState<CardApplication<CardLandParcel>[]>([]);

  useEffect(() => {
    api
      .get<{ data: CardApplication<CardLandParcel>[] }>(`${env.API_URL}/applications?types[]=land-parcels`)
      .then((response) => {
        setApplications(response.data.data);
        setLoading(false);
      });
  }, []);

  return (
    <div className="applications-page">
      {!isLoading && applications.length !== 0 && (
        <>
          <div className="applications-page__header">
            <h1 className="applications-page__title">Found {applications.length} applications</h1>
            <Button className="applications-page__header-button" to="new" text="Add application" />
          </div>
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
    </div>
  );
}
