import { useParams } from "react-router";
import "../application-page.sass";
import { useEffect, useState } from "react";
import { LandParcel } from "../../../models/land-parcel";
import { Application } from "../../../models/application";
import api from "../../../services/api";
import { env } from "../../../env";
import { MainSection } from "../../../components/application-page/main-section";
import { LandParcelSection } from "../../../components/application-page/land-parcel-section";
import { LocationSection } from "../../../components/application-page/location-section";
import { Spinner } from "../../../components/spinner/spinner";

export function LandParcelPage() {
  const { id } = useParams<{ id: string }>();
  const [application, setApplication] = useState(new Application<LandParcel>());
  const [isLoading, setLoading] = useState(true);

  useEffect(() => {
    api.get<Application<LandParcel>>(`${env.API_URL}/applications/${id}`).then(({ data }) => {
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
          <LandParcelSection landParcel={application.applicable} />
          <LocationSection address={application.address} />
        </>
      )}
    </div>
  );
}
