import { useState } from "react";
import { env } from "../../env";
import { Icon } from "../icon/icon";
import { ImageUploader } from "../image-uploader/image-uploader";

type PhotoFormProps = { initialState?: number[] };

export function PhotoForm({ initialState = [] }: PhotoFormProps) {
  const [ids, setIds] = useState<number[]>(initialState);
  const maxPhotos = 15;

  function addIndices(newIds: number[]) {
    setIds([...ids, ...newIds]);
  }

  function removeIndex(idToRemove: number) {
    setIds(ids.filter((id) => id !== idToRemove));
  }

  return (
    <form className="form photo-form" id="photoForm">
      {ids.map((id) => (
        <div key={id} className="photo-form__photo">
          <input className="photo-form__hidden" type="hidden" name="photos[]" value={id} />
          <img src={`${env.API_URL}/photos/${id}`} className="photo-form__image" />
          <Icon className="photo-form__remove" name="delete" onClick={() => removeIndex(id)} />
        </div>
      ))}
      {maxPhotos - ids.length > 0 && <ImageUploader addIndices={addIndices} allowedPhotos={maxPhotos - ids.length} />}
      <input type="hidden" name="photos[]" value={[]} />
    </form>
  );
}
