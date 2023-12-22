export class StorageUser {
  public get image(): string {
    return localStorage.getItem("user_image_url") as string;
  }

  public set image(value: string) {
    localStorage.setItem("user_image_url", value);
  }

  public get token(): string {
    return localStorage.getItem("user_access_token") as string;
  }

  public set token(value: string) {
    localStorage.setItem("user_access_token", value);
  }

  public get name(): string {
    return localStorage.getItem("user_name") as string;
  }

  public set name(value: string) {
    localStorage.setItem("user_name", value);
  }
}
