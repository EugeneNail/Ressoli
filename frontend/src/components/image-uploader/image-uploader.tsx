import { useState, DragEvent, ChangeEvent } from "react";
import { Spinner } from "../spinner/spinner";
import "./image-uploader.sass";
import Resizer from "react-image-file-resizer";
import { Photo } from "../../models/photo";
import "../button/button.sass";
import { useHttp } from "../../services/useHttp";

type ImageUploaderProps = {
  addIndices: (newIndices: number[]) => void;
  maxPhotos: number;
};

export function ImageUploader({ addIndices, maxPhotos }: ImageUploaderProps) {
  const http = useHttp();
  const [fileCount, setFileCount] = useState(0);
  const [isDragged, setDragged] = useState(false);
  const [isLoading, setLoading] = useState(false);

  function handleDragOver(event: DragEvent<HTMLInputElement>) {
    event.preventDefault();
    setDragged(true);
  }

  function handleDrop(event: DragEvent<HTMLInputElement>) {
    event.preventDefault();
    setDragged(false);
    const files = event.dataTransfer.files as FileList;

    if (files == null || files.length === 0) {
      return;
    }

    upload(files);
  }

  async function handleChange(event: ChangeEvent<HTMLInputElement>) {
    const files = event.target.files as FileList;

    if (files == null || files.length === 0) {
      return;
    }

    await upload(files);
    //Fixes the issue where the input element does not allow you to re-upload the same set of photos
    event.target.value = "";
  }

  async function upload(files: FileList) {
    setLoading(true);
    setFileCount(files.length);
    const payload = new FormData();

    for (let i = 0; i < Math.min(files.length, maxPhotos); i++) {
      const file = (await resizeFile(files[i])) as File;
      payload.append("photos[]", file);
    }
    // Looks like axios can't properly send files with the Content-Type header set to "application/json"
    const { data, status } = await http.post<Photo[]>("/photos", payload, {
      headers: { "Content-Type": "multipart/form-data" },
    });

    if (status === 201) {
      const newIndices = data.map((photo) => photo.id);
      addIndices(newIndices);
    }

    setLoading(false);
  }

  function resizeFile(file: File) {
    return new Promise((resolve) => {
      Resizer.imageFileResizer(file, 2000, 1000, "JPEG", 100, 0, (uri) => resolve(uri), "blob");
    });
  }

  return (
    <div
      className="image-uploader"
      onDragOver={handleDragOver}
      onDragLeave={() => setDragged(false)}
      onDrop={handleDrop}
    >
      {isLoading && <Spinner className="image-uploader__spinner" />}
      {!isLoading && (
        <p className="image-uploader__message">
          {isDragged ? "Release the button to drop" : "Drag your photos here or"}
        </p>
      )}
      {isLoading && (
        <p className="image-uploader__message">
          Uploading {Math.min(fileCount, maxPhotos)} photo{fileCount === 1 ? "" : "s"} to the server
        </p>
      )}
      {!isDragged && !isLoading && (
        <label htmlFor="imageUploader" className="image-uploader__button button primary">
          <input
            type="file"
            id="imageUploader"
            multiple
            className="image-uploader__input"
            onChange={handleChange}
            accept="image/png, image/jpeg, image/jpg"
          />
          Browse
        </label>
      )}
    </div>
  );
}
