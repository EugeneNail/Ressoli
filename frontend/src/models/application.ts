import { House } from "./House";
import { Address } from "./address";
import { Client } from "./client";
import { LandParcel } from "./land-parcel";

export class Application<A extends LandParcel | House> {
  id: number = 0;
  isActive: boolean = false;
  contract: string = "";
  price: number = 0;
  hasMortgage: boolean = false;
  address: Address = new Address();
  client: Client = new Client();
  applicable: A = {} as A;
  createdAt: Date = new Date();
}
