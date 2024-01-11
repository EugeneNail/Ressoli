import { useState } from "react";
import { env } from "../../env";
import { Photo } from "../../models/photo";
import classNames from "classnames";

type PhotoSectionProps = {
  photos: Photo[];
};

export function PhotoSection({ photos }: PhotoSectionProps) {
  const [currentPhotoId, setCurrentPhotoId] = useState(photos[0].id);

  return (
    <div className="application-page__section photo-section">
      <img className="photo-section__main-photo" src={`${env.API_URL}/photos/${currentPhotoId}`} />
      <div className="photo-section__photos">
        {photos &&
          photos.length > 0 &&
          photos.map((photo) => (
            <img
              src={`${env.API_URL}/photos/${photo.id}`}
              className={classNames("photo-section__photo", { selected: photo.id === currentPhotoId })}
              onClick={() => setCurrentPhotoId(photo.id)}
            />
          ))}
      </div>
    </div>
  );
}
