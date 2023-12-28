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

export function ApartmentsPage() {
  const [isLoading, setLoading] = useState(true);
  const [applications, setApplications] = useState<CardApplication<CardApartment>[]>([]);

  useEffect(() => {
    api
      .get<{ data: CardApplication<CardApartment>[] }>(`${env.API_URL}/applications?types[]=apartments`)
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
