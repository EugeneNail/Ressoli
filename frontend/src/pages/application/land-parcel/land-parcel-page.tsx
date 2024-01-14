import { useParams } from "react-router";
import "../application-page.sass";
import { useEffect, useState } from "react";
import { LandParcel } from "../../../models/land-parcel";
import { Application } from "../../../models/application";
import { env } from "../../../env";
import { MainSection } from "../../../components/application-page/main-section";
import { LandParcelSection } from "../../../components/application-page/land-parcel-section";
import { LocationSection } from "../../../components/application-page/location-section";
import { Spinner } from "../../../components/spinner/spinner";
import { PhotoSection } from "../../../components/application-page/photo-section";
import { useHttp } from "../../../services/useHttp";

export function LandParcelPage() {
  const { id } = useParams<{ id: string }>();
  const [application, setApplication] = useState(new Application<LandParcel>());
  const [isLoading, setLoading] = useState(true);
  const http = useHttp();

  useEffect(() => {
    http.get<Application<LandParcel>>(`${env.API_URL}/applications/${id}`).then(({ data }) => {
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
          <LandParcelSection landParcel={application.applicable} />
          <LocationSection address={application.address} />
        </>
      )}
    </div>
  );
}
