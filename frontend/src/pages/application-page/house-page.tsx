import { useParams } from "react-router";
import "../application-page.sass";
import { useEffect, useState } from "react";
import { Application } from "../../models/application";
import api from "../../services/api";
import { env } from "../../env";
import { MainSection } from "../../components/application-page/main-section";
import { LocationSection } from "../../components/application-page/location-section";
import { House } from "../../models/House";
import { HouseSection } from "../../components/application-page/house-section";

export function HousePage() {
  const { id } = useParams<{ id: string }>();
  const [application, setApplication] = useState(new Application<House>());

  useEffect(() => {
    api.get<Application<House>>(`${env.API_URL}/applications/${id}`).then(({ data }) => setApplication(data));
  }, []);

  return (
    <div className="application-page">
      <MainSection application={application} />
      <HouseSection house={application.applicable} />
      <LocationSection address={application.address} />
    </div>
  );
}