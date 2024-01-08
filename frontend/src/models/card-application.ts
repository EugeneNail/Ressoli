import { CardApartment } from "./card-apartment";
import { Address } from "./address";
import { CardHouse } from "./card-house";
import { CardLandParcel } from "./card-land-parcel";

export type CardApplication<A extends CardLandParcel | CardHouse | CardApartment> = {
  id: number;
  isActive: boolean;
  preview: number | null;
  address: Address;
  date: Date;
  client: string;
  contract: string;
  applicable: A;
  hasMortgage: boolean;
  price: number;
};
