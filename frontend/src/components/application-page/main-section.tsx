import { useState } from "react";
import { Application } from "../../models/application";
import { LandParcel } from "../../models/land-parcel";
import { Format } from "../../services/format";
import Button, { ButtonStyle } from "../button/button";
import { MainSectionAttribute } from "./main-section-attribute";
import api from "../../services/api";
import { env } from "../../env";
import classNames from "classnames";

type MainSectionProps = {
  application: Application<LandParcel>;
};

export function MainSection({ application }: MainSectionProps) {
  const [isActive, setActive] = useState(application.isActive);

  async function removeFromArchive() {
    const { status } = await api.patch(`${env.API_URL}/applications/${application.id}/activate`);

    if (status === 204) {
      setActive(true);
    }
  }

  async function moveToArchive() {
    const { status } = await api.patch(`${env.API_URL}/applications/${application.id}/archive`);

    if (status === 204) {
      setActive(false);
    }
  }

  return (
    <section className="main-section application-page__section">
      <div className="main-section__header">
        <h1 className="main-section__title">Land Parcel Application №{application.id}</h1>
        <div className={classNames("main-section__status", { archived: !isActive })}>
          {isActive ? "Active" : "Archived"}
        </div>
      </div>
      <div className="main-section__attributes">
        <MainSectionAttribute icon="description" value={application.contract} />
        <MainSectionAttribute icon="payments" value={application.price} />
        <MainSectionAttribute icon="calendar_month" value={Format.toShortDate(application.createdAt)} />
        {application.hasMortgage && <MainSectionAttribute icon="credit_card" value="Mortgage" />}
        <MainSectionAttribute icon="account_box" value={`${application.client.name} ${application.client.lastName}`} />
        <MainSectionAttribute icon="contact_phone" value={application.client.phoneNumber} />
      </div>
      <div className="main-section__buttons">
        <a href="#location">
          <Button className="main_section__button" text="Show on map" />
        </a>
        <Button className="main_section__button" style={ButtonStyle.secondary} text="Edit" to={"edit"} />
        {isActive && (
          <Button
            className="main_section__button"
            style={ButtonStyle.secondary}
            text="Move to archive"
            action={moveToArchive}
          />
        )}

        {!isActive && (
          <Button
            className="main_section__button"
            style={ButtonStyle.secondary}
            text="Remove from archive"
            action={removeFromArchive}
          />
        )}
      </div>
    </section>
  );
}
