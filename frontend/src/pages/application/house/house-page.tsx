import { useParams } from "react-router";
import "../application-page.sass";
import { useEffect, useState } from "react";
import { Application } from "../../../models/application";
import api from "../../../services/api";
import { env } from "../../../env";
import { MainSection } from "../../../components/application-page/main-section";
import { LocationSection } from "../../../components/application-page/location-section";
import { House } from "../../../models/House";
import { HouseSection } from "../../../components/application-page/house-section";
import { Spinner } from "../../../components/spinner/spinner";
import { PhotoSection } from "../../../components/application-page/photo-section";

export function HousePage() {
  const { id } = useParams<{ id: string }>();
  const [application, setApplication] = useState(new Application<House>());
  const [isLoading, setLoading] = useState(true);

  useEffect(() => {
    api.get<Application<House>>(`${env.API_URL}/applications/${id}`).then(({ data }) => {
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
          {application.photos.length > 0 && <PhotoSection photos={application.photos} />}
          <HouseSection house={application.applicable} />
          <LocationSection address={application.address} />
        </>
      )}
    </div>
  );
}
