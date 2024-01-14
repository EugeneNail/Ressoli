import { House } from "./House";
import { Address } from "./address";
import { Apartment } from "./apartment";
import { Client } from "./client";
import { LandParcel } from "./land-parcel";
import { Photo } from "./photo";

export class Application<A extends LandParcel | House | Apartment> {
  id: number = 0;
  userId: number = 0;
  isActive: boolean = false;
  photos: Photo[] = [];
  contract: string = "";
  price: number = 0;
  hasMortgage: boolean = false;
  address: Address = new Address();
  client: Client = new Client();
  applicable: A = {} as A;
  createdAt: Date = new Date();
}
