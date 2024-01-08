import { useParams } from "react-router";
import "../application-page.sass";
import { useEffect, useState } from "react";
import { Application } from "../../../models/application";
import api from "../../../services/api";
import { env } from "../../../env";
import { MainSection } from "../../../components/application-page/main-section";
import { LocationSection } from "../../../components/application-page/location-section";
import { Apartment } from "../../../models/apartment";
import { ApartmentSection } from "../../../components/application-page/apartment-section";
import { Spinner } from "../../../components/spinner/spinner";
import { PhotoSection } from "../../../components/application-page/photo-section";

export function ApartmentPage() {
  const [isLoading, setLoading] = useState(true);
  const { id } = useParams<{ id: string }>();
  const [application, setApplication] = useState(new Application<Apartment>());

  useEffect(() => {
    api.get<Application<Apartment>>(`${env.API_URL}/applications/${id}`).then(({ data }) => {
      setApplication(data);
      setLoading(false);
    });
  }, []);

  return (
    <div className="application-page">
      {isLoading && <Spinner className="application-page__spinner" />}
      {!isLoading && (
        <>
          <MainSection application={application} />
          <ApartmentSection apartment={application.applicable} />
          {application.photos && <PhotoSection photos={application.photos} />}
          <LocationSection address={application.address} />
        </>
      )}
    </div>
  );
}
